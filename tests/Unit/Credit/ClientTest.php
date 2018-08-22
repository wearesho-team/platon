<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Credit;

use GuzzleHttp;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments\Credit\TransferInterface;
use Wearesho\Bobra\Platon;
use Wearesho\Bobra\Platon\Config;
use Wearesho\Bobra\Platon\Credit\Client;
use Wearesho\Bobra\Platon\Credit\CreditToCard;
use Wearesho\Bobra\Platon\Credit\Response;
use Wearesho\Bobra\Platon\Credit\Response\Validator;

/**
 * Class ClientTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Credit
 * @coversDefaultClass \Wearesho\Bobra\Platon\Credit\Client
 */
class ClientTest extends TestCase
{
    /** @var GuzzleHttp\Handler\MockHandler */
    protected $mock;

    /** @var array */
    protected $container;

    /** @var Client */
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = new GuzzleHttp\Handler\MockHandler();
        $this->container = [];

        $history = GuzzleHttp\Middleware::history($this->container);
        $stack = new GuzzleHttp\HandlerStack($this->mock);
        $stack->push($history);

        $this->client = new Client(
            new Config('test', 'test', 'CC'),
            new GuzzleHttp\Client(['handler' => $stack,]),
            new Validator()
        );
    }

    public function testGetConfig(): void
    {
        $config = $this->client->getConfig();
        $this->assertEquals('test', $config->getKey());
        $this->assertEquals('test', $config->getPass());
        $this->assertEquals('CC', $config->getPayment());
    }

    /**
     * @expectedException GuzzleHttp\Exception\RequestException
     * @expectedExceptionMessage Runtime error
     */
    public function testInvalidResponseFormat(): void
    {
        $this->mock->append(
            new GuzzleHttp\Exception\RequestException(
                'Runtime error',
                new GuzzleHttp\Psr7\Request('GET', 'http://google.com/'),
                new GuzzleHttp\Psr7\Response(500, [], 'invalid json body')
            )
        );
        $this->client->send(new CreditToCard(1, 100, md5(uniqid())));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid card token
     */
    public function testInvalidCardToken(): void
    {
        $this->client->send(new CreditToCard(1, 100, 'invalid token'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid card token
     */
    public function testTooBigCardToken(): void
    {
        $this->client->send(new CreditToCard(1, 100, md5('1') . '1'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid card token
     */
    public function testTooBigCardNumber(): void
    {
        $this->client->send(new CreditToCard(1, 100, '11111111111111111'));
    }

    /**
     * @expectedException GuzzleHttp\Exception\RequestException
     * @expectedExceptionMessage Runtime error
     */
    public function testMissingResultKey(): void
    {
        $this->mock->append(
            new GuzzleHttp\Exception\RequestException(
                'Runtime error',
                new GuzzleHttp\Psr7\Request('GET', 'http://google.com/'),
                new GuzzleHttp\Psr7\Response(500, [], '{}')
            )
        );
        $this->client->send(new CreditToCard(1, 100, md5(uniqid())));
    }

    /**
     * @expectedException GuzzleHttp\Exception\RequestException
     * @expectedExceptionMessage Runtime error
     */
    public function testMissingErrorMessage(): void
    {
        $this->mock->append(
            new GuzzleHttp\Exception\RequestException(
                'Runtime error',
                new GuzzleHttp\Psr7\Request('GET', 'http://google.com/'),
                new GuzzleHttp\Psr7\Response(500, [], json_encode(['result' => 'fail']))
            )
        );

        $this->client->send(new CreditToCard(1, 100, md5(uniqid())));
    }

    public function testSuccessResponse(): void
    {
        $this->mock->append(
            new GuzzleHttp\Psr7\Response(200, [], json_encode(['result' => 'SUCCESS',]))
        );

        $response = $this->client->send(new CreditToCard(1, 100, md5(uniqid())));
        $this->assertTrue($response->isSuccessful());
    }

    public function testGenerateCardData(): void
    {
        $client = new class() extends Client
        {
            public function __construct()
            {
                parent::__construct(
                    new Config('test', 'test', 'CC'),
                    new GuzzleHttp\Client(),
                    new Validator()
                );
            }

            public function getParams(TransferInterface $credit2Card): array
            {
                return $this->generateParams($credit2Card);
            }
        };

        $card = "5555555555555599";

        $params = $client->getParams(new CreditToCard(1, 100, $card));
        $this->assertEquals(Platon\Credit\CreditToCardInterface::ACTION_CARD, $params['action']);
        $this->assertArrayHasKey('card_number', $params);
        $this->assertEquals($card, $params['card_number']);
    }

    public function testGenerateExpireDate(): void
    {
        $client = new class extends Client
        {
            public function __construct()
            {
                parent::__construct(
                    new Config('test', 'test', 'CC'),
                    new GuzzleHttp\Client(),
                    new Validator()
                );
            }

            public function getParams(TransferInterface $credit2Card): array
            {
                return $this->generateParams($credit2Card);
            }
        };

        $card = "5555555555555599";

        $credit2Card = new Platon\Credit\CardTransfer(1, 100, $card, 1, 20);

        $params = $client->getParams($credit2Card);
        $this->assertArrayHasKey('card_exp_month', $params);
        $this->assertEquals('01', $params['card_exp_month']);
        $this->assertArrayHasKey('card_exp_year', $params);
        $this->assertEquals('2020', $params['card_exp_year']);
    }
}
