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

    public function createPayment(
        Payments\UrlPairInterface $pair,
        Payments\TransactionInterface $transaction
    ): Payments\PaymentInterface {
        $data = $this->getDataParam($transaction);

        return new Payment(
            $transaction->getService(),
            $this->config->getLanguage(),
            $this->config->getPayment(),
            $pair,
            $this->getSign($data, $this->config->getPayment(), $pair->getGood()),
            $data,
            $this->config->getKey(),
            $this->config->getUrl(),
            $this->transformInfoIntoExt($transaction->getInfo()),
            $transaction->getType()
        );
    }

    protected function transformInfoIntoExt(array $info): array
    {
        $maxExt = null;
        $ext = [];

        foreach ($info as $key => $value) {
            if (is_int($key)) {
                $maxExt = max($key, $maxExt);
            } else {
                $key = is_null($maxExt) ? $maxExt = 1 : ++$maxExt;
            }

            $ext['ext' . $key] = $value;
        }

        return $ext;
    }

    protected function getDataParam(Payments\TransactionInterface $transaction)
    {
        $amount = number_format(
            (float)($transaction->getAmount() / 100),
            2,
            '.',
            ''
        );

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
    protected function getSign(string $data, string $payment, string $url)
    {
        $result_hash = strrev($this->config->getKey())
            . strrev($payment)
            . strrev($data)
            . strrev($url)
            . strrev($this->config->getPass());

        return md5(strtoupper($result_hash));
    }
}
