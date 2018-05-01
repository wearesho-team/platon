<?php

namespace Wearesho\Bobra\Platon;

use Horat1us\Environment;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Platon
 */
class EnvironmentConfig extends Environment\Config implements ConfigInterface
{
    /**
     * @inheritdoc
     */
    public function getKey(): string
    {
        return $this->getEnv('PLATON_KEY');
    }

    /**
     * @inheritdoc
     */
    public function getPass(): string
    {
        return $this->getEnv('PLATON_PASS');
    }

    /**
     * @inheritdoc
     */
    public function getPayment(): string
    {
        return $this->getEnv('PLATON_PAYMENT', 'CC');
    }

    /**
     * @inheritdoc
     */
    public function getBaseUrl(): string
    {
        return $this->getEnv('PLATON_URL', ConfigInterface::PAYMENT_URL);
    }

    /**
     * @inheritdoc
     */
    public function getLanguage(): string
    {
        return $this->getEnv('PLATON_LANGUAGE', ConfigInterface::LANGUAGE_UA);
    }
}
