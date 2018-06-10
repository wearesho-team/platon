<?php

namespace Wearesho\Bobra\Platon\Notification;

/**
 * Interface ConfigProviderInterface
 * @package Wearesho\Bobra\Platon\Notification
 */
interface ConfigProviderInterface
{
    public function checkSign(string $order, string $card, string $sign): void;
}
