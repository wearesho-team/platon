<?php

namespace Wearesho\Bobra\Platon\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments;
use Wearesho\Bobra\Platon;

/**
 * Class ClientTest
 * @package Wearesho\Bobra\Platon\Tests\Unit
 * @coversDefaultClass \Wearesho\Bobra\Platon\Client
 */
class ClientTest extends TestCase
{
    /** @var Platon\Client */
    protected $client;

    protected function setUp(): void
    {
        $this->client = new PLaton\Client(new Platon\Config("key_string", "pass_string", "payment_string"));
    }

    public function testConstruct(): void
    {
        $this->assertEquals(
            "f9a26c2992ad137f224d3908b0947f91",
            $this->client
                ->createPayment(
                    new Payments\UrlPair("good_string_pair"),
                    new Payments\Transaction(
                        228,
                        2.28,
                        "type_string",
                        "description_string"
                    )
                )
                ->jsonSerialize()["data"]['sign']
        );

        $this->assertEquals(
            "d050360db1a3bcf0ac4e869160f87fcc",
            (new Platon\Client(new Platon\Config("key_string2", "pass_string2", "payment_string")))
                ->createPayment(
                    new Payments\UrlPair("good_string_pair"),
                    new Payments\Transaction(
                        228,
                        2.28,
                        "type_string",
                        "description_string"
                    )
                )
                ->jsonSerialize()["data"]['sign']
        );
    }

    public function testCreatePayment(): void
    {
        $this->assertEquals(
            new Platon\Payment(
                228,
                "ua",
                "payment_string",
                new Payments\UrlPair("good_string_pair"),
                "f9a26c2992ad137f224d3908b0947f91",
                "eyJhbW91bnQiOiIyLjI3IiwibmFtZSI6ImRlc2NyaXB0aW9uX3N0cmluZyIsImN1cnJlbmN5IjoiVUFIIiwi" .
                "MCI6InJlY3VycmluZyJ9",
                "key_string",
                "https://secure.platononline.com/payment/auth",
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
                )
            )
        );
    }

    public function testCreatePaymentWithTransactionLanguage(): void
    {
        $this->assertEquals(
            new Platon\Payment(
                228,
                "ru",
                "payment_string",
                new Payments\UrlPair("good_string_pair"),
                "f9a26c2992ad137f224d3908b0947f91",
                "eyJhbW91bnQiOiIyLjI3IiwibmFtZSI6ImRlc2NyaXB0aW9uX3N0cmluZyIsImN1cnJlbmN5IjoiVUFIIiwi" .
                "MCI6InJlY3VycmluZyJ9",
                "key_string",
                "https://secure.platononline.com/payment/auth",
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
                    "type_string",
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
                )
            )
        );
    }
}
