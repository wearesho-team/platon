<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Payment;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments\UrlPair;
use Wearesho\Bobra\Platon;

class C2ATest extends TestCase
{
    protected const AMOUNT = '100.12';
    protected const DESCRIPTION = 'Some Description';
    protected const CURRENCY = 'UAH';

    public function testJsonAdditionalFields(): void
    {
        $payment = new Platon\Payment\C2A(
            1,
            Platon\ConfigInterface::LANGUAGE_UA,
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

        $this->assertEquals([
            'amount' => static::AMOUNT,
            'description' => static::DESCRIPTION,
            'currency' => static::CURRENCY,
            'key' => 'key',
            'payment' => 'C2A,CC',
            'url' => '',
            'error_url' => '',
            'lang' => 'uk',
            'sign' => 'sign'
        ], $json['data']);

        $this->assertEquals(Platon\Payment\C2A::TYPE, $json['data']['payment']);
    }

    public function testJsonCardToken(): void
    {
        $payment = new Platon\Payment\C2A(
            1,
            Platon\ConfigInterface::LANGUAGE_UA,
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
