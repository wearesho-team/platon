<?php

namespace Wearesho\Bobra\Platon\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments;
use Wearesho\Bobra\Platon\Payment;

class PaymentTest extends TestCase
{
    /** @var Payment */
    protected $payment;

    protected function setUp()
    {
        $this->payment = new Payment(
            2,
            "de",
            "payment_string",
            new Payments\UrlPair("good_string"),
            "qwerty_sign",
            "data_string",
            "key_string",
            ["one", "two", "three"],
            "some_formId"
        );
    }

    public function testConstruct()
    {
        $this->assertEquals(
            [
                'data' => 'data_string',
                'key' => 'key_string',
                'payment' => 'payment_string',
                'url' => 'good_string',
                'error_url' => 'good_string',
                'lang' => 'de',
                'sign' => 'qwerty_sign',
                'formid' => 'some_formId',
                'ext0' => 'one',
                'ext1' => 'two',
                'ext2' => 'three'
            ],
            $this->payment->jsonSerialize()
        );
    }
}
