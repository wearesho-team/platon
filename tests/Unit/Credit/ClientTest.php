<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Credit;

use GuzzleHttp;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Config;
use Wearesho\Bobra\Platon\Credit\Client;
use Wearesho\Bobra\Platon\Credit\CreditToCard;

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
            new GuzzleHttp\Client(['handler' => $stack,])
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

    /**
     * @expectedException \Wearesho\Bobra\Platon\Credit\Exception
     * @expectedExceptionMessage Custom error message
     */
    public function testErrorHandling(): void
    {

        $this->mock->append(
            new GuzzleHttp\Exception\RequestException(
                'Runtime error',
                new GuzzleHttp\Psr7\Request('GET', 'http://google.com/'),
                new GuzzleHttp\Psr7\Response(500, [], json_encode([
                    'result' => 'fail',
                    'error_message' => 'Custom error message',
                ]))
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
}
