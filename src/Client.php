<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments;

/**
 * Class Client
 * @package Wearesho\Bobra\Platon
 */
class Client implements Payments\ClientInterface
{
    /** @var ConfigInterface */
    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function createPayment(Payments\UrlPairInterface $pair, Payments\TransactionInterface $transaction): Payments\PaymentInterface
    {
        $url = $this->config->getUrl();
        $key = $this->config->getKey();

    }
}

