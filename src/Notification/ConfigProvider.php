<?php

namespace Wearesho\Bobra\Platon\Notification;

use Wearesho\Bobra\Platon;
use Horat1us\Environment;

class ConfigProvider implements Platon\Notification\ConfigProviderInterface
{
    /** @var Platon\ConfigInterface[] */
    protected array $configs;

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
     * @throws InvalidSignException
     */
    public function provide(string $order, string $card, string $sign, ?string $email = null): Platon\ConfigInterface
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

            $debitConfigSign = md5(strtoupper(
                strrev($config->getPass())
                . strrev($order)
                . strrev(
                    substr($card, 0, 6)
                    . substr($card, -4)
                )
            ));

            if ($debitConfigSign === $sign) {
                return $config;
            }

            $debitConfigSignWithEmail = md5(strtoupper(
                strrev($email)
                . strrev($config->getPass())
                . strrev($order)
                . strrev(
                    substr($card, 0, 6)
                    . substr($card, -4)
                )
            ));

            if ($debitConfigSignWithEmail == $sign) {
                return $config;
            }
        }

        throw new InvalidSignException();
    }
}
