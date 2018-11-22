<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Info;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Platon\Info
 */
interface ConfigInterface
{
    public function getPublicKey(): string;

    public function getPrivateKey(): string;
}
