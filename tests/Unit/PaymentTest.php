<?php

namespace Wearesho\Bobra\Platon\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments;
use Wearesho\Bobra\Platon\Payment;

class PaymentTest extends TestCase
{
    public function testConstruct()
    {
        $payment = new Payment\CC(
            2,
            "de",
            new Payments\UrlPair("good_string"),
            "qwerty_sign",
            "key_string",
            "form_url_string",
            "data_string",
            ["one", "two", "three"],
            "some_formId"
        );

        $this->assertEquals(
            [
                'data' => 'data_string',
                'key' => 'key_string',
                'payment' => Payment\CC::TYPE,
                'url' => 'good_string',
                'error_url' => 'good_string',
                'lang' => 'de',
                'sign' => 'qwerty_sign',
                'formid' => 'some_formId',
                '0' => 'one',
                '1' => 'two',
                '2' => 'three',
            ],
            $payment->jsonSerialize()['data']
        );
    }

    public function testFormIdVerify(): void
    {
        $payment = new Payment\CC(
            2,
            "de",
            new Payments\UrlPair("good_string"),
            "qwerty_sign",
            "key_string",
            "form_url_string",
            "data_string",
            ["one", "two", "three"],
            Payment::FORM_ID_VERIFY
        );

        $this->assertArraySubset([
            'data' => 'data_string',
            'ext10' => 'verify',
            'formid' => 'VERIFY',
            'req_token' => 'Y',
        ], $payment->jsonSerialize()['data']);
    }
}
