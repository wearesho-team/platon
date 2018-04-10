<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments\PaymentInterface;
use Wearesho\Bobra\Payments\PaymentTrait;

/**
 * Class Payment
 * @package Wearesho\Bobra\Platon
 */
class Payment implements PaymentInterface
{
    use PaymentTrait;

    /** @var string */
    protected $lang;

    /** @var string */
    protected $url;

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

    public function __construct(
        int $id,
        string $lang,
        string $payment,
        string $url,
        string $sign,
        string $data,
        string $key,
        array $ext = [],
        string $formId = null
    )
    {
        $this->id = $id;
        $this->lang = $lang;
        $this->url = $url;
        $this->sign = $sign;
        $this->data = $data;
        $this->ext = $ext;
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
            'url' => $this->url,
            'lang' => $this->lang,
            'sign' => $this->sign,
        ];

        if (!is_null($this->formId)) {
            $json['formid'] = $this->formId;
        }

        foreach ($this->ext as $item => $value) {
            $json['ext' . (int)$item] = $value;
        }

        return $json;
    }
}
