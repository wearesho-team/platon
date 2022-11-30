<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Info;

class Config implements ConfigInterface
{
    protected string $publicKey;

    protected string $privateKey;

    protected string $baseUrl;

    public function __construct(
        string $publicKey,
        string $privateKey,
        string $baseUrl = ConfigInterface::DEFAULT_BASE_URL
    ) {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->baseUrl = $baseUrl;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
