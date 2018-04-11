<?php

namespace Wearesho\Bobra\Platon;

use Horat1us\Environment;

class EnvironmentConfig extends Environment\Config implements ConfigInterface
{
    use LanguageConfigTrait;

    /**
     * Public key for Platon
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->getEnv('PLATON_KEY');
    }

    /**
     * Private key for signing data
     *
     * @return string
     */
    public function getPass(): string
    {
        return $this->getEnv('PLATON_PASS');
    }

    /**
     * @return string
     */
    public function getPayment(): string
    {
        return $this->getEnv('PLATON_PAYMENT', 'CC');
    }

    /**
     * URL for sending form on front-end
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getEnv('PLATON_URL', static::PAYMENT_URL);
    }
}
