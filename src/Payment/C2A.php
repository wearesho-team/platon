<?php

namespace Wearesho\Bobra\Platon\Payment;

use Wearesho\Bobra\Payments\PayerDetailsInterface;
use Wearesho\Bobra\Payments\UrlPairInterface;
use Wearesho\Bobra\Platon;

class C2A extends Platon\Payment
{
    public const TYPE = 'C2A,CC';
    public const TYPE_CARD_TOKEN = 'C2AT,CCT';

    protected string $amount;

    protected string $description;

    protected string $currency;

    public function __construct(
        int $id,
        string $lang,
        UrlPairInterface $urlPair,
        PayerDetailsInterface $payerDetails,
        string $sign,
        string $key,
        string $formUrl,
        string $amount,
        string $description,
        string $currency,
        array $ext = [],
        string $formId = null,
        string $cardToken = null
    ) {
        parent::__construct($id, $lang, $urlPair, $payerDetails, $sign, $key, $formUrl, $ext, $formId, $cardToken);

        $this->amount = $amount;
        $this->description = $description;
        $this->currency = $currency;
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json['data'] = array_merge($json['data'] ?? [], [
            'amount' => $this->amount,
            'description' => $this->description,
            'currency' => $this->currency,
        ]);
        if (!is_null($this->cardToken)) {
            $json['data']['payment'] = static::TYPE_CARD_TOKEN;
        }

        return $json;
    }
}
