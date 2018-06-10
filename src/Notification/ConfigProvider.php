<?php

namespace Wearesho\Bobra\Platon\Notification;

use Wearesho\Bobra\Platon;
use Horat1us\Environment;

/**
 * Class ConfigProvider
 * @package Wearesho\Bobra\Platon\Notification
 */
class ConfigProvider implements Platon\Notification\ConfigProviderInterface
{
    /** @var Platon\ConfigInterface[] */
    protected $configs;

    /**
     * ConfigProvider constructor.
     * @param Platon\ConfigInterface[] $configs
     */
    public function __construct(array $configs = [])
    {
        foreach ($configs as $config) {
            if (!$config instanceof Platon\ConfigInterface) {
                throw new \InvalidArgumentException(
                    "All configs have to implement " . Platon\ConfigInterface::class
                );
            }
        }
        $this->configs = $configs;
    }

    /**
     * @param string $order
     * @param string $card
     * @param string $sign
     * @return Platon\ConfigInterface
     * @throws InvalidSignException
     */
    public function provide(string $order, string $card, string $sign): Platon\ConfigInterface
    {
        foreach ($this->configs as $config) {
            $configSign = md5(strtoupper(
                $config->getPass()
                . $order
                . strrev(
                    substr($card, 0, 6)
                    . substr($card, -4)
                )
            ));

            if ($configSign === $sign) {
                return $config;
            }
        }

        throw new InvalidSignException();
    }
}
