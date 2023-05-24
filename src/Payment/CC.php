<?php

namespace Wearesho\Bobra\Platon\Payment;

use Wearesho\Bobra\Payments\PayerDetailsInterface;
use Wearesho\Bobra\Payments\UrlPairInterface;
use Wearesho\Bobra\Platon;

class CC extends Platon\Payment
{
    public const TYPE = 'CC';
    public const TYPE_CARD_TOKEN = 'CCT';

    protected string $data;

    public function __construct(
        int $id,
        string $lang,
        UrlPairInterface $urlPair,
        PayerDetailsInterface $payerDetails,
        string $sign,
        string $key,
        string $formUrl,
        string $data,
        array $ext = [],
        string $formId = null,
        string $cardToken = null
    ) {
        parent::__construct($id, $lang, $urlPair, $payerDetails, $sign, $key, $formUrl, $ext, $formId, $cardToken);
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json['data'] = array_merge($json['data'] ?? [], [
            'data' => $this->data,
        ]);
        if (!is_null($this->cardToken)) {
            $json['data']['payment'] = static::TYPE_CARD_TOKEN;
        }

        return $json;
    }
}
