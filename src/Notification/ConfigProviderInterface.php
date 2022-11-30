<?php

namespace Wearesho\Bobra\Platon\Notification;

use Wearesho\Bobra\Platon;

interface ConfigProviderInterface
{
    /**
     * @throws InvalidSignException
     */
    public function provide(string $order, string $card, string $sign): Platon\ConfigInterface;
}
