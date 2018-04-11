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
        $data = $this->_getDataParam($transaction);

        return new Payment(
            $transaction->getService(),
            $this->config->getLanguage(),
            $this->config->getPayment(),
            $pair,
            $this->_getSign($data, $this->config->getPayment(),$pair->getGood()),
            $data,
            $this->config->getKey(),
            $transaction->getInfo(),
            $transaction->getType()
        );
    }

    protected function _getDataParam(Payments\TransactionInterface $transaction)
    {
        $amount = number_format((float)($transaction->getAmount() / 100), 2, '.', '');

        return base64_encode(json_encode([
            'amount' => $amount,
            'name' => $transaction->getDescription(),
            'currency' => $transaction->getCurrency(),
            'recurring'
        ]));
    }

    /**
     * Set 'sign' item for POST request
     * @param string $data
     * @param string $payment
     * @param string $url
     * @return string
     */
    protected function _getSign(string $data, string $payment, string $url)
    {
        $result_hash = strrev($this->config->getKey())
            . strrev($payment)
            . strrev($data)
            . strrev($url)
            . strrev($this->config->getPass());

        return md5(strtoupper($result_hash));
    }
}
