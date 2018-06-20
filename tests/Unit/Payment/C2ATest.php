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
    protected const NAME = 'Some Description';
    protected const CURRENCY = 'UAH';

    /** @var Platon\Payment\C2A */
    protected $payment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payment = new Platon\Payment\C2A(
            1,
            Platon\ConfigInterface::LANGUAGE_RU,
            new UrlPair('', ''),
            'sign',
            'key',
            'formUrl',
            static::AMOUNT,
            static::NAME,
            static::CURRENCY
        );
    }

    public function testJsonAdditionalFields(): void
    {
        $json = $this->payment->jsonSerialize();

        $this->assertArrayHasKey('data', $json);
        $this->assertArrayHasKey('action', $json);

        $this->assertArraySubset([
            'amount' => static::AMOUNT,
            'name' => static::NAME,
            'currency' => static::CURRENCY,
        ], $this->payment->jsonSerialize()['data']);
    }
}
