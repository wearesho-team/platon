<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments;

/**
 * Class Client
 * @package Wearesho\Bobra\Platon
 */
class Client implements Payments\ClientInterface
{
    use ValidateLanguage;

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
        $payment = $this->config->getPayment();
        $ext = $this->transformInfoIntoExt($transaction->getInfo());
        $language = $this->fetchLanguage($transaction);
        $formId = $transaction instanceof TransactionInterface ? $transaction->getFormId() : $transaction->getType();

        switch ($payment) {
            case Payment\CC::TYPE:
                $data = $this->getDataParam($transaction);
                return new Payment\CC(
                    $transaction->getService(),
                    $language,
                    $pair,
                    $this->getSign($payment, $data, $pair->getGood()),
                    $this->config->getKey(),
                    $this->getUrl(),
                    $data,
                    $ext,
                    $formId
                );
            case Payment\C2A::TYPE:
                $amount = $this->fetchAmount($transaction);
                return new Payment\C2A(
                    $transaction->getService(),
                    $language,
                    $pair,
                    $this->getSign(
                        $payment,
                        $amount,
                        $transaction->getCurrency(),
                        $transaction->getDescription(),
                        $pair->getGood()
                    ),
                    $this->config->getKey(),
                    $this->getUrl(),
                    $amount,
                    $transaction->getDescription(),
                    $transaction->getCurrency(),
                    $ext,
                    $formId
                );
        }

        throw new \InvalidArgumentException("Payment type $payment is not supported");
    }

    protected function getUrl(): string
    {
        return rtrim($this->config->getBaseUrl(), '/') . '/payment/auth';
    }

    protected function fetchLanguage(Payments\TransactionInterface $transaction): string
    {
        if (!$transaction instanceof Payments\HasLanguage) {
            return $this->config->getLanguage();
        }

        $language = $transaction->getLanguage();
        $this->validateLanguage($language);

        return $language;
    }

    protected function fetchAmount(Payments\TransactionInterface $transaction): string
    {
        return number_format(
            (float)($transaction->getAmount() / 100),
            2,
            '.',
            ''
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

    protected function getDataParam(Payments\TransactionInterface $transaction): string
    {
        return base64_encode(json_encode([
            'amount' => $this->fetchAmount($transaction),
            'name' => $transaction->getDescription(),
            'currency' => $transaction->getCurrency(),
            'recurring'
        ]));
    }

    /**
     * Set 'sign' item for POST request
     * @param array $params
     * @return string
     */
    protected function getSign(...$params)
    {
        $middleHash = implode('', array_map('strrev', $params));

        $resultHash = strrev($this->config->getKey())
            . $middleHash
            . strrev($this->config->getPass());

        return md5(strtoupper($resultHash));
    }
}
