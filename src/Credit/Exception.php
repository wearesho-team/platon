<?php

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Payments\Credit;

/**
 * Class Exception
 * @package Wearesho\Bobra\Platon\Credit
 */
class Exception extends Credit\Exception
{
    /** @var Response */
    protected $response;

    public function __construct(
        Credit\TransferInterface $transfer,
        Response $response,
        string $message,
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($transfer, $message, $code, $previous);
        $this->response = $response;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
