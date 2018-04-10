<?php

namespace Wearesho\Bobra\Platon;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Platon
 */
interface ConfigInterface
{
    /**
     * URL for sending form on front-end
     *
     * @return string
     */
    public function getUrl(): string;

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
}
