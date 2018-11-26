<?php

namespace Wearesho\Bobra\Platon\Info;

use Horat1us\Environment;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Platon\Info
 */
class EnvironmentConfig extends Environment\Config implements ConfigInterface
{
    public function __construct(string $keyPrefix = 'PLATON_INFO_')
    {
        parent::__construct($keyPrefix);
    }

    public function getPublicKey(): string
    {
        return $this->getEnv('PUBLIC_KEY');
    }

    public function getPrivateKey(): string
    {
        return $this->getEnv('PRIVATE_KEY');
    }

    public function getBaseUrl(): string
    {
        return $this->getEnv('BASE_URL', ConfigInterface::DEFAULT_BASE_URL);
    }
}
