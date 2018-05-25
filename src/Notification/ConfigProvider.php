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
     * @param Platon\ConfigInterface|Platon\ConfigInterface[] $configs
     */
    public function __construct($configs = [])
    {
        foreach ((array)$configs as $config) {
            if (!$config instanceof Platon\ConfigInterface) {
                throw new \InvalidArgumentException(
                    "All configs have to implement " . Platon\ConfigInterface::class
                );
            }
        }
        $this->configs = $configs;
    }

    /**
     * @param string $key
     * @return Platon\ConfigInterface
     */
    public function provide(string $key): Platon\ConfigInterface
    {
        foreach ($this->configs as $config) {
            try {
                $merchantKey = $config->getKey();
            } catch (Environment\MissingEnvironmentException $exception) {
                continue;
            }
            if ($merchantKey === $key) {
                return $config;
            }
        }

        throw new UnsupportedMerchantException($key);
    }
}
