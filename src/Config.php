<?php

namespace Wearesho\Bobra\Platon;

/**
 * Class Config
 * @package Wearesho\Bobra\Platon
 */
class Config implements ConfigInterface
{
    use LanguageConfigTrait;

    /** @var string */
    protected $key;

    /** @var string */
    protected $pass;

    /** @var string */
    protected $payment;

    public function __construct(string $key, string $pass, string $payment)
    {
        $this->key = $key;
        $this->pass = $pass;
        $this->payment = $payment;
    }

    /**
     * URL for sending form on front-end
     *
     * @return string
     */
    public function getUrl(): string
    {
        return static::PAYMENT_URL;
    }

    /**
     * Public key for Platon
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Private key for signing data
     *
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @return string
     */
    public function getPayment(): string
    {
        return $this->payment;
    }
}
