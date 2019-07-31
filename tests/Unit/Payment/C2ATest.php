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
        ], $payment->jsonSerialize()['data']);
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

        $json = $payment->jsonSerialize()['data'];
        $this->assertArrayHasKey('card_token', $json);
        $this->assertEquals($cardToken, $json['card_token']);
    }
}
