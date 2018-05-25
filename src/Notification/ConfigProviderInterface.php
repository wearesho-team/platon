<?php

namespace Wearesho\Bobra\Platon\Notification;

use Wearesho\Bobra\Platon;

/**
 * Interface ConfigProviderInterface
 * @package Wearesho\Bobra\Platon\Notification
 */
interface ConfigProviderInterface
{
    public function provide(string $key): Platon\ConfigInterface;
}
