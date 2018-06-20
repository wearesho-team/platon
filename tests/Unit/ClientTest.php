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
        $this->client = new PLaton\Client(new Platon\Config("key_string", "pass_string", "CC"));
    }

    public function testConstruct(): void
    {
        $this->assertEquals(
            "793fc3079812312726827296b88ecdb5",
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
            "ae0ee3d26a3074acde93d7836cff4a0b",
            (new Platon\Client(new Platon\Config("key_string2", "pass_string2", "CC")))
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
            new Platon\Payment\CC(
                228,
                "uk",
                new Payments\UrlPair("good_string_pair"),
                "793fc3079812312726827296b88ecdb5",
                "key_string",
                "https://secure.platononline.com/payment/auth",
                "eyJhbW91bnQiOiIyLjI3IiwibmFtZSI6ImRlc2NyaXB0aW9uX3N0cmluZyIsImN1cnJlbmN5IjoiVUFIIiwi" .
                "MCI6InJlY3VycmluZyJ9",
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
            new Platon\Payment\CC(
                228,
                "ru",
                new Payments\UrlPair("good_string_pair"),
                "793fc3079812312726827296b88ecdb5",
                "key_string",
                "https://secure.platononline.com/payment/auth",
                "eyJhbW91bnQiOiIyLjI3IiwibmFtZSI6ImRlc2NyaXB0aW9uX3N0cmluZyIsImN1cnJlbmN5IjoiVUFIIiwi" .
                "MCI6InJlY3VycmluZyJ9",
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
                )
            )
        );
    }
}
