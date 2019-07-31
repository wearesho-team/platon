<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Payment;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments\UrlPair;
use Wearesho\Bobra\Platon;

/**
 * Class C2ATest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Payment
 */
class C2ATest extends TestCase
{
    protected const AMOUNT = '100.12';
    protected const DESCRIPTION = 'Some Description';
    protected const CURRENCY = 'UAH';

    public function testJsonAdditionalFields(): void
    {
        $payment = new Platon\Payment\C2A(
            1,
            Platon\ConfigInterface::LANGUAGE_RU,
            new UrlPair('', ''),
            'sign',
            'key',
            'formUrl',
            static::AMOUNT,
            static::DESCRIPTION,
            static::CURRENCY
        );
        $json = $payment->jsonSerialize();

        $this->assertArrayHasKey('data', $json);
        $this->assertArrayHasKey('action', $json);

        $this->assertArraySubset([
            'amount' => static::AMOUNT,
            'description' => static::DESCRIPTION,
            'currency' => static::CURRENCY,
        ], $json['data']);

        $this->assertEquals(Platon\Payment\C2A::TYPE, $json['data']['payment']);
    }

    public function testJsonCardToken(): void
    {
        $payment = new Platon\Payment\C2A(
            1,
            Platon\ConfigInterface::LANGUAGE_RU,
            new UrlPair('', ''),
            'sign',
            'key',
            'formUrl',
            static::AMOUNT,
            static::DESCRIPTION,
            static::CURRENCY,
            [],
            'formId',
            $cardToken = 'cardToken'
        );

        $data = $payment->jsonSerialize()['data'];
        $this->assertArrayHasKey('card_token', $data);
        $this->assertEquals($cardToken, $data['card_token']);

        $this->assertEquals(Platon\Payment\C2A::TYPE_CARD_TOKEN, $data['payment']);
    }
}
