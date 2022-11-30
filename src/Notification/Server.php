<?php

namespace Wearesho\Bobra\Platon\Notification;

use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Wearesho\Bobra\Platon;

class Server
{
    protected ConfigProviderInterface $configProvider;

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
        $config = $this->validateSign($data);

        return new Payment(
            $data['id'],
            $config->getKey(),
            $data['order'],
            $data['amount'],
            $data['currency'],
            $data['status'],
            $data['card'],
            Carbon::parse($data['date'], new \DateTimeZone('UTC')),
            $data['rc_token'] ?? null,
            $this->extractPaymentData($data),
            $data
        );
    }

    /**
     * @param array $data
     * @return Platon\ConfigInterface
     * @throws InvalidSignException
     */
    protected function validateSign(array $data): Platon\ConfigInterface
    {
        $requiredRequestKeys = ['order', 'card', 'sign',];

        foreach ($requiredRequestKeys as $requestKey) {
            if (!array_key_exists($requestKey, $data)) {
                throw new \InvalidArgumentException("Key `{$requestKey}` is required");
            }
        }

        return $this->configProvider->provide($data['order'], $data['card'], $data['sign']);
    }

    protected function extractPaymentData(array $data): array
    {
        static $paymentDataPrefix = 'ext';

        $paymentData = [];
        foreach ($data as $key => $value) {
            if (!str_starts_with($key, $paymentDataPrefix)) {
                continue;
            }
            $paymentData[$key] = $value;
        }
        return $paymentData;
    }
}
