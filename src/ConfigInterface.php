<?php

namespace Wearesho\Bobra\Platon;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Platon
 */
interface ConfigInterface
{
    public const LANGUAGE_RU = 'ru';
    public const LANGUAGE_UA = 'uk';

    public const PAYMENT_URL = 'https://secure.platononline.com/';

    /**
     * URL for sending form on front-end
     *
     * @return string
     */
    public function getBaseUrl(): string;

    /**
     * Public key for Platon
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Private key for signing data
     *
     * @return string
     */
    public function getPass(): string;

    /**
     * @return string
     */
    public function getLanguage(): string;

    /**
     * @return string
     */
    public function getPayment(): string;
}
