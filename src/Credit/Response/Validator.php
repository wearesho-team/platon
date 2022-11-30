<?php

namespace Wearesho\Bobra\Platon\Credit\Response;

use Wearesho\Bobra\Payments\Credit;
use Wearesho\Bobra\Platon;

/**
 * Class Validator
 * @package Wearesho\Bobra\Platon\Credit\Response
 */
class Validator
{
    /**
     * @param Platon\Credit\Response $response
     * @param Credit\TransferInterface $transfer
     * @throws Platon\Credit\Exception
     */
    public function validate(Platon\Credit\Response $response, Credit\TransferInterface $transfer): void
    {
        if ($response->isSuccessful()) {
            return;
        }

        switch ($response->getResult()) {
            case Result::ERROR:
                $isDuplicatedTransfer = $response['error_message'] === 'Order already exists';

                if ($isDuplicatedTransfer) {
                    throw new class (
                        $transfer,
                        $response,
                        $response['error_message']
                    ) extends Platon\Credit\Exception implements Credit\Exception\DuplicatedTransfer {
                    };
                }

                throw new Platon\Credit\Exception($transfer, $response, $response['error_message']);
            case Result::DECLINED:
                if (mb_strpos($response['decline_reason'], 'Invalid card') !== false) {
                    throw new class (
                        $transfer,
                        $response,
                        'Invalid card'
                    ) extends Platon\Credit\Exception implements Credit\Exception\InvalidCardToken {
                    };
                }

                throw new Platon\Credit\Exception($transfer, $response, $response['decline_reason']);
            default:
                throw new Platon\Credit\Exception($transfer, $response, "Unknown result: {$response->getResult()}");
        }
    }
}
