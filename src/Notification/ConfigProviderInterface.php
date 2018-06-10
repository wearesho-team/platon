<?php

namespace Wearesho\Bobra\Platon\Notification;

use Wearesho\Bobra\Platon;

/**
 * Interface ConfigProviderInterface
 * @package Wearesho\Bobra\Platon\Notification
 */
interface ConfigProviderInterface
{
    /**
     * @param string $order
     * @param string $card
     * @param string $sign
     * @return Platon\ConfigInterface
     * @throws InvalidSignException
     */
    public function provide(string $order, string $card, string $sign): Platon\ConfigInterface;
}
