<?php

namespace Wearesho\Bobra\Platon\Notification;

use Wearesho\Bobra\Platon\ConfigInterface;

/**
 * Class Server
 * @package Wearesho\Bobra\Platon\Notification
 */
class Server
{
    /** @var ConfigInterface */
    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function handle(array $data): Payment
    {
        $payment = $this->parseData($data);
        return $payment;
    }

    protected function parseData(array $data): Payment
    {
        $this->validateSign($data);

        $paymentData = [];

        foreach ([1, 2, 3, 4,] as $extKey) {
            $key = "ext{$extKey}";

            if (array_key_exists($key, $data)) {
                $paymentData[$extKey] = $data[$extKey];
            }
        }

        return new Payment(
            $data['id'],
            $data['order'],
            $data['amount'],
            $data['currency'],
            $data['status'],
            $data['card'],
            $data['date'],
            $paymentData
        );
    }

    protected function validateSign(array $data): void
    {
        $requiredRequestKeys = ['order', 'card'];
        foreach ($requiredRequestKeys as $requestKey) {
            if (!array_key_exists($requestKey, $data)) {

                throw new \InvalidArgumentException("Key {$requestKey} is required");
            }
        }

        $sign = md5(strtoupper(
            $this->config->getPass()
            . $data['order']
            . strrev(
                substr($data['card'], 0, 6)
                . substr($data['card'], -4)
            )
        ));

        if ($sign !== $data['sign']) {
            throw new \InvalidArgumentException("Invalid sign");
        }
    }
}
