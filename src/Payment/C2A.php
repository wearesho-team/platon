<?php

namespace Wearesho\Bobra\Platon\Payment;

use Wearesho\Bobra\Payments\UrlPairInterface;
use Wearesho\Bobra\Platon;

/**
 * Class C2A
 * @package Wearesho\Bobra\Platon\Payment
 */
class C2A extends Platon\Payment
{
    public const TYPE = 'C2A,CC';

    /** @var int */
    protected $amount;

    /** @var string */
    protected $description;

    /** @var string */
    protected $currency;

    public function __construct(
        int $id,
        string $lang,
        UrlPairInterface $urlPair,
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
        parent::__construct($id, $lang, $urlPair, $sign, $key, $formUrl, $ext, $formId, $cardToken);

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

        return $json;
    }
}
