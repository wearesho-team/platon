<?php

namespace Wearesho\Bobra\Platon\Payment;

use Wearesho\Bobra\Payments\UrlPairInterface;
use Wearesho\Bobra\Platon;

/**
 * Class CC
 * @package Wearesho\Bobra\Platon\Payment
 */
class CC extends Platon\Payment
{
    public const TYPE = 'CC';

    /** @var string */
    protected $data;

    public function __construct(
        int $id,
        string $lang,
        UrlPairInterface $urlPair,
        string $sign,
        string $key,
        string $formUrl,
        string $data,
        array $ext = [],
        string $formId = null,
        string $cardToken = null
    ) {
        parent::__construct($id, $lang, $urlPair, $sign, $key, $formUrl, $ext, $formId, $cardToken);
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json['data'] = array_merge($json['data'] ?? [], [
            'data' => $this->data,
            'payment' => is_null($this->cardToken) ? static::TYPE : static::TYPE . 'T',
        ]);

        return $json;
    }
}
