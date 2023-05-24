<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit;

use Wearesho\Bobra\Payments\PayerDetails;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments;
use Wearesho\Bobra\Platon;

/**
 * @coversDefaultClass \Wearesho\Bobra\Platon\Client
 */
class ClientTest extends TestCase
{
    protected Platon\Client $client;

    protected function setUp(): void
    {
        $this->client = new PLaton\Client(new Platon\Config("key_string", "pass_string", "CC"));
    }

    public function testConstruct(): void
    {
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789');
        $this->assertEquals(
            "b13ee30a74ea76d7a89871caf8140639",
            $this->client
                ->createPayment(
                    new Payments\UrlPair("good_string_pair"),
                    new Payments\Transaction(
                        228,
                        2.28,
                        "type_string",
                        "description_string"
                    ),
                    $payerDetails
                )
                ->jsonSerialize()["data"]['sign']
        );

        $this->assertEquals(
            "2b5a662f2ba4ff321cec61763ed42811",
            (new Platon\Client(new Platon\Config("key_string2", "pass_string2", "CC")))
                ->createPayment(
                    new Payments\UrlPair("good_string_pair"),
                    new Payments\Transaction(
                        228,
                        2.28,
                        "type_string",
                        "description_string"
                    ),
                    $payerDetails
                )
                ->jsonSerialize()["data"]['sign']
        );
    }

    public function testCreatePayment(): void
    {
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789');
        $this->assertEquals(
            new Platon\Payment\CC(
                228,
                "uk",
                new Payments\UrlPair("good_string_pair"),
                $payerDetails,
                "b13ee30a74ea76d7a89871caf8140639",
                "key_string",
                "https://secure.platononline.com/payment/auth",
                "eyJhbW91bnQiOiIyLjI4IiwibmFtZSI6ImRlc2NyaXB0aW9uX3N0cmluZyIsImN1cnJlbmN5IjoiVUFIIiwi"
                . "MCI6InJlY3VycmluZyJ9",
                [
                    'ext0' => "zero",
                    "ext1" => "one",
                    'ext2' => "two",
                    "ext3" => "three",
                ],
                "type_string"
            ),
            $this->client->createPayment(
                new Payments\UrlPair("good_string_pair"),
                new Payments\Transaction(
                    228,
                    2.28,
                    "type_string",
                    "description_string",
                    [
                        '0' => "zero",
                        '1' => "one",
                        '2' => "two",
                        'key1' => "three",
                    ]
                ),
                $payerDetails
            )
        );
    }

    public function testCreatePaymentWithTransactionLanguage(): void
    {
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789');
        $this->assertEquals(
            new Platon\Payment\CC(
                228,
                "ru",
                new Payments\UrlPair("good_string_pair"),
                $payerDetails,
                "b13ee30a74ea76d7a89871caf8140639",
                "key_string",
                "https://secure.platononline.com/payment/auth",
                "eyJhbW91bnQiOiIyLjI4IiwibmFtZSI6ImRlc2NyaXB0aW9uX3N0cmluZyIsImN1cnJlbmN5IjoiVUFIIiwi"
                . "MCI6InJlY3VycmluZyJ9",
                [
                    'ext0' => "zero",
                    "ext1" => "one",
                    'ext2' => "two",
                    "ext3" => "three",
                ],
                null
            ),
            $this->client->createPayment(
                new Payments\UrlPair("good_string_pair"),
                new Platon\LanguageTransaction(
                    228,
                    2.28,
                    "CC",
                    "description_string",
                    [
                        '0' => "zero",
                        '1' => "one",
                        '2' => "two",
                        'key1' => "three",
                    ],
                    'UAH',
                    null,
                    Platon\ConfigInterface::LANGUAGE_RU
                ),
                $payerDetails
            )
        );
    }

    public function testInvalidPaymentType(): void
    {
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789');
        $this->client = new PLaton\Client(new Platon\Config("key_string", "pass_string", "TEST"));
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Payment type TEST is not supported');
        $this->client->createPayment(
            new Payments\UrlPair("good_string_pair"),
            new Platon\Transaction(
                228,
                2.28,
                "CC",
                "description",
                [
                    '0' => "zero",
                    '1' => "one",
                    '2' => "two",
                    'key1' => "three",
                ],
                'UAH',
                'formId'
            ),
            $payerDetails
        );
    }


    public function testCreateC2APayment(): void
    {
        $payerDetails = new PayerDetails('John', 'Doe', '380123456789');
        $this->client = new PLaton\Client(new Platon\Config("key_string", "pass_string", "C2A,CC"));

        $this->assertEquals(
            new Platon\Payment\C2A(
                228,
                "uk",
                new Payments\UrlPair("good_string_pair"),
                $payerDetails,
                "26b693a3f0519f0a52edd1a0bbb53005",
                "key_string",
                "https://secure.platononline.com/payment/auth",
                '2.28',
                'description',
                'UAH',
                [
                    'ext0' => "zero",
                    "ext1" => "one",
                    'ext2' => "two",
                    "ext3" => "three",
                ],
                'formId'
            ),
            $this->client->createPayment(
                new Payments\UrlPair("good_string_pair"),
                new Platon\Transaction(
                    228,
                    2.28,
                    "CC",
                    "description",
                    [
                        '0' => "zero",
                        '1' => "one",
                        '2' => "two",
                        'key1' => "three",
                    ],
                    'UAH',
                    'formId'
                ),
                $payerDetails
            )
        );
    }
}
