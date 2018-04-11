<?php

namespace Wearesho\Bobra\Platon;


/**
 * Class Config
 * @package Wearesho\Bobra\Platon
 */
class Config implements ConfigInterface
{
    /** @var string */
    protected $key;

    /** @var string */
    protected $pass;

    /** @var string */
    protected $url = 'https://secure.platononline.com/payment/auth';

    /** @var string */
    protected $language = Config::LANGUAGE_UA;

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
        return $this->url;
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
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage(string $language): self
    {
        if (
            $language !== static::LANGUAGE_UA
            && $language !== static::LANGUAGE_RU
        ) {
            throw new \InvalidArgumentException("Invalid language");
        }

        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayment(): string
    {
        return $this->payment;
    }
}
