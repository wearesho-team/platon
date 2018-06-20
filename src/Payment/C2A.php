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

    /** @var string description */
    protected $name;

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
        string $name,
        string $currency,
        array $ext = [],
        string $formId = null
    ) {
        parent::__construct($id, $lang, $urlPair, $sign, $key, $formUrl, $ext, $formId);
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json['data'] = array_merge($json['data'] ?? [], [
            'amount' => $this->amount,
            'name' => $this->name,
            'currency' => $this->currency,
        ]);

        return $json;
    }
}
