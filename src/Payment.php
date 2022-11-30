<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments\PaymentInterface;
use Wearesho\Bobra\Payments\PaymentTrait;
use Wearesho\Bobra\Payments\UrlPairInterface;

/**
 * Class Payment
 * @package Wearesho\Bobra\Platon
 */
abstract class Payment implements PaymentInterface
{
    use PaymentTrait;

    public const TYPE = null;
    public const FORM_ID_VERIFY = 'VERIFY';

    protected string $lang;

    protected UrlPairInterface $urlPair;

    protected string $sign;

    protected string $key;


    protected array $ext = [];

    protected string $formUrl;

    protected ?string $formId = null;

    protected ?string $cardToken = null;

    public function __construct(
        int $id,
        string $lang,
        UrlPairInterface $urlPair,
        string $sign,
        string $key,
        string $formUrl,
        array $ext = [],
        string $formId = null,
        string $cardToken = null
    ) {
        $this->id = $id;
        $this->lang = $lang;
        $this->urlPair = $urlPair;
        $this->sign = $sign;
        $this->ext = $ext;
        $this->formUrl = $formUrl;
        $this->formId = $formId;
        $this->key = $key;
        $this->cardToken = $cardToken;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        $json = [
            'key' => $this->key,
            'payment' => static::TYPE,
            'url' => $this->urlPair->getGood(),
            'error_url' => $this->urlPair->getBad(),
            'lang' => $this->lang,
            'sign' => $this->sign,
        ];

        if (!is_null($this->formId)) {
            $json['formid'] = $this->formId;

            if ($this->formId === static::FORM_ID_VERIFY) {
                $this->ext['ext10'] = strtolower(static::FORM_ID_VERIFY);
                $json['req_token'] = 'Y';
            }
        }

        if (!empty($this->ext)) {
            $json = array_merge($json, $this->ext);
        }

        if (!is_null($this->cardToken)) {
            $json['card_token'] = $this->cardToken;
        }

        return [
            'action' => $this->formUrl,
            'data' => $json,
        ];
    }
}
