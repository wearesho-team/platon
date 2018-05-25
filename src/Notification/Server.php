<?php

namespace Wearesho\Bobra\Platon\Notification;

/**
 * Class Server
 * @package Wearesho\Bobra\Platon\Notification
 */
class Server
{
    /** @var ConfigProviderInterface */
    protected $configProvider;

    public function __construct(ConfigProviderInterface $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * @param array $data
     * @return Payment
     * @throws InvalidSignException
     * @throws \InvalidArgumentException
     */
    public function handle(array $data): Payment
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

    /**
     * @param array $data
     * @throws InvalidSignException
     */
    protected function validateSign(array $data): void
    {
        $requiredRequestKeys = ['order', 'card'];
        foreach ($requiredRequestKeys as $requestKey) {
            if (!array_key_exists($requestKey, $data)) {
                throw new \InvalidArgumentException("Key {$requestKey} is required");
            }
        }

        $config = $this->configProvider->provide($data['key']);

        $sign = md5(strtoupper(
            $config->getPass()
            . $data['order']
            . strrev(
                substr($data['card'], 0, 6)
                . substr($data['card'], -4)
            )
        ));

        if ($sign !== $data['sign']) {
            throw new InvalidSignException();
        }
    }
}