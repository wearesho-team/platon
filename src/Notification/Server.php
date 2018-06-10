<?php

namespace Wearesho\Bobra\Platon\Notification;

use Carbon\Carbon;

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
                $paymentData[$key] = $data[$key];
            }
        }

        return new Payment(
            $data['id'],
            $data['order'],
            $data['amount'],
            $data['currency'],
            $data['status'],
            $data['card'],
            Carbon::parse($data['date']),
            $data['rc_token'],
            $paymentData
        );
    }

    /**
     * @param array $data
     * @throws InvalidSignException
     */
    protected function validateSign(array $data): void
    {
        $requiredRequestKeys = ['order', 'card', 'sign',];

        foreach ($requiredRequestKeys as $requestKey) {
            if (!array_key_exists($requestKey, $data)) {
                throw new \InvalidArgumentException("Key `{$requestKey}` is required");
            }
        }

        $this->configProvider->checkSign($data['order'], $data['card'], $data['sign']);
    }
}
