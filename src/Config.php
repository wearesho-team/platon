<?php

namespace Wearesho\Bobra\Platon;

class Config implements ConfigInterface
{
    use LanguageConfigTrait;

    protected string $key;

    protected string $pass;

    protected string $payment;

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
    public function getBaseUrl(): string
    {
        return static::PAYMENT_URL;
    }

    /**
     * Public key for Platon
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
