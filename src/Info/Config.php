<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Info;

/**
 * Class Config
 * @package Wearesho\Bobra\Platon\Info
 */
class Config implements ConfigInterface
{
    /** @var string */
    protected $publicKey;

    /** @var string */
    protected $privateKey;

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }


    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }
}
