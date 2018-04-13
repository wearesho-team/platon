<?php

namespace Wearesho\Bobra\Platon\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments;
use Wearesho\Bobra\Platon\Client;
use Wearesho\Bobra\Platon\Config;
use Wearesho\Bobra\Platon\Payment;

class ClientTest extends TestCase
{
    /** @var Client */
    protected $client;

    protected function setUp()
    {
        $this->client = new Client(new Config("key_string", "pass_string", "payment_string"));
    }

    public function testConstruct()
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
            (new Client(new Config("key_string2", "pass_string2", "payment_string")))
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

    public function testCreatePayment()
    {
        $this->assertEquals(
            new Payment(
                228,
                "ua",
                "payment_string",
                new Payments\UrlPair("good_string_pair"),
                "f9a26c2992ad137f224d3908b0947f91",
                "eyJhbW91bnQiOiIyLjI3IiwibmFtZSI6ImRlc2NyaXB0aW9uX3N0cmluZyIsImN1cnJlbmN5IjoiVUFIIiwi".
                "MCI6InJlY3VycmluZyJ9",
                "key_string",
                "https://secure.platononline.com/payment/auth",
                [],
                "type_string"
            ),
            $this->client->createPayment(
                new Payments\UrlPair("good_string_pair"),
                new Payments\Transaction(
                    228,
                    2.28,
                    "type_string",
                    "description_string"
                )
            )
        );
    }
}
