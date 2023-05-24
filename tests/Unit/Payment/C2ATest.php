<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Payment;

use Wearesho\Bobra\Payments\PayerDetails;
use Wearesho\Bobra\Payments\UrlPair;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon;

class C2ATest extends TestCase
{
    protected const AMOUNT = '100.12';
    protected const DESCRIPTION = 'Some Description';
    protected const CURRENCY = 'UAH';

    public function testJsonAdditionalFields(): void
    {
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789', 'john.doe@example.com');

        $payment = new Platon\Payment\C2A(
            1,
            Platon\ConfigInterface::LANGUAGE_UA,
            new UrlPair('', ''),
            $payerDetails,
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
            'sign' => 'sign',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '380123456789',
            'email' => 'john.doe@example.com',
        ], $json['data']);

        $this->assertEquals(Platon\Payment\C2A::TYPE, $json['data']['payment']);
    }

    public function testJsonCardToken(): void
    {
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789');
        $payment = new Platon\Payment\C2A(
            1,
            Platon\ConfigInterface::LANGUAGE_UA,
            new UrlPair('', ''),
            $payerDetails,
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
