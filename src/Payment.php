<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments\PaymentInterface;
use Wearesho\Bobra\Payments\PaymentTrait;
use Wearesho\Bobra\Payments\UrlPairInterface;

/**
 * Class Payment
 * @package Wearesho\Bobra\Platon
 */
class Payment implements PaymentInterface
{
    use PaymentTrait;

    /** @var string */
    protected $lang;

    /** @var UrlPairInterface */
    protected $urlPair;

    /** @var string */
    protected $sign;

    /** @var string */
    protected $data;

    /** @var string */
    protected $payment;

    /** @var string */
    protected $key;

    /** @var string|null */
    protected $formId = null;

    /** @var array */
    protected $ext = [];

    /** @var string */
    protected $formUrl;

    public function __construct(
        int $id,
        string $lang,
        string $payment,
        UrlPairInterface $urlPair,
        string $sign,
        string $data,
        string $key,
        string $formUrl,
        array $ext = [],
        string $formId = null
    ) {
        $this->id = $id;
        $this->lang = $lang;
        $this->urlPair = $urlPair;
        $this->sign = $sign;
        $this->data = $data;
        $this->ext = $ext;
        $this->formUrl = $formUrl;
        $this->payment = $payment;
        $this->formId = $formId;
        $this->key = $key;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        $json = [
            'data' => $this->data,
            'key' => $this->key,
            'payment' => $this->payment,
            'url' => $this->urlPair->getGood(),
            'error_url' => $this->urlPair->getBad(),
            'lang' => $this->lang,
            'sign' => $this->sign,
        ];

        if (!is_null($this->formId)) {
            $json['formid'] = $this->formId;
        }

        if (!empty($this->ext)) {
            $json = array_merge($json, $this->ext);
        }

        return [
            'action' => $this->formUrl,
            'data' => $json,
        ];
    }
}
