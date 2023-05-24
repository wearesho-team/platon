<?php

namespace Wearesho\Bobra\Platon\Tests\Unit;

use Wearesho\Bobra\Payments\PayerDetails;
use Wearesho\Bobra\Platon\Payment;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments;

class PaymentTest extends TestCase
{
    public function testConstruct()
    {
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789', 'john.doe@example.com');

        $payment = new Payment\CC(
            2,
            "de",
            new Payments\UrlPair("good_string"),
            $payerDetails,
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
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => '380123456789',
                'email' => 'john.doe@example.com',
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
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789', 'john.doe@example.com');

        $payment = new Payment\CC(
            2,
            "de",
            new Payments\UrlPair("good_string"),
            $payerDetails,
            "qwerty_sign",
            "key_string",
            "form_url_string",
            "data_string",
            ["one", "two", "three"],
            Payment::FORM_ID_VERIFY
        );

        $this->assertEquals([
            'data' => 'data_string',
            'ext10' => 'verify',
            'formid' => 'VERIFY',
            'req_token' => 'Y',
            'key' => 'key_string',
            'payment' => 'CC',
            'url' => 'good_string',
            'error_url' => 'good_string',
            'lang' => 'de',
            'sign' => 'qwerty_sign',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '380123456789',
            'email' => 'john.doe@example.com',
            "one", "two", "three"
        ], $payment->jsonSerialize()['data']);
    }

    public function testPayerDetailsWithoutEmail(): void
    {
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789');

        $payment = new Payment\CC(
            2,
            "de",
            new Payments\UrlPair("good_string"),
            $payerDetails,
            "qwerty_sign",
            "key_string",
            "form_url_string",
            "data_string",
            ["one", "two", "three"],
            Payment::FORM_ID_VERIFY
        );

        $this->assertEquals([
            'data' => 'data_string',
            'ext10' => 'verify',
            'formid' => 'VERIFY',
            'req_token' => 'Y',
            'key' => 'key_string',
            'payment' => 'CC',
            'url' => 'good_string',
            'error_url' => 'good_string',
            'lang' => 'de',
            'sign' => 'qwerty_sign',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '380123456789',
            "one", "two", "three"
        ], $payment->jsonSerialize()['data']);
    }
}
