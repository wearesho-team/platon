<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Info;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Platon\Info
 */
interface ConfigInterface
{
    public const DEFAULT_BASE_URL = 'http://62.113.194.121/';

    public function getPublicKey(): string;

    public function getPrivateKey(): string;

    public function getBaseUrl(): string;
}
