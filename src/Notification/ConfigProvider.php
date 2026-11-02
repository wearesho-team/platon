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
        $cardDigits = strrev(substr($card, 0, 6) . substr($card, -4));
        $reversedEmail = strrev($email ?? '');
        $sign = strtolower($sign);

        foreach ($this->configs as $config) {
            $pass = $config->getPass();
            $candidates = [
                // Documented card callback sign: strrev(email) . pass . order . strrev(first6 . last4)
                $reversedEmail . $pass . $order . $cardDigits,
                // Debit (recurring) callback sign: pass and order are reversed too
                $reversedEmail . strrev($pass) . strrev($order) . $cardDigits,
            ];
            if ($reversedEmail !== '') {
                // Callbacks that carry an email but are signed without it
                $candidates[] = $pass . $order . $cardDigits;
                $candidates[] = strrev($pass) . strrev($order) . $cardDigits;
            }

            foreach ($candidates as $candidate) {
                if (hash_equals(md5(strtoupper($candidate)), $sign)) {
                    return $config;
                }
            }
        }

        throw new InvalidSignException();
    }
}
