<?php

namespace Wearesho\Bobra\Platon\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Payment;
use Wearesho\Bobra\Payments;

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
            "key_string"
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
                'sign' => 'qwerty_sign'

            ],
            $this->payment->jsonSerialize()
        );
    }

    public function testJsonSerialize()
    {
        $local_payment = new Payment(
            228,
            "de",
            "payment_string_local",
            new Payments\UrlPair("good_string_local"),
            "qwerty_sign_local",
            "data_string_local",
            "key_string_local"
        );

        $this->assertEquals(
            [
                'data' => 'data_string_local',
                'key' => 'key_string_local',
                'payment' => 'payment_string_local',
                'url' => 'good_string_local',
                'error_url' => 'good_string_local',
                'lang' => 'de',
                'sign' => 'qwerty_sign_local'

            ],
            $local_payment->jsonSerialize()
        );
    }
}
