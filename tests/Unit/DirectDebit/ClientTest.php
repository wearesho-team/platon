<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\DirectDebit;

use GuzzleHttp;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon;
use Wearesho\Bobra\Platon\DirectDebit\Client;
use Wearesho\Bobra\Platon\DirectDebit\Request;

class ClientTest extends TestCase
{
    protected GuzzleHttp\Handler\MockHandler $mock;

    protected array $container;

    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = new GuzzleHttp\Handler\MockHandler();
        $this->container = [];

        $stack = new GuzzleHttp\HandlerStack($this->mock);
        $stack->push(GuzzleHttp\Middleware::history($this->container));

        $this->client = new Client(
            new Platon\Config('key', 'pass', 'CC'),
            new GuzzleHttp\Client(['handler' => $stack,]),
        );
    }

    public function testChargeRequest(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'action' => 'SALE',
            'result' => 'SUCCESS',
            'status' => 'SETTLED',
        ])));

        $request = new Request(
            orderId: '1-1700000000',
            amount: 100.5,
            description: 'description',
            cardToken: 'token',
            termUrl: 'https://example.com/',
            phone: '380930000000',
            email: 'payer@example.com',
            ext: ['one', 'two'],
        );
        $response = $this->client->charge($request);
        $this->assertEquals('SUCCESS', $response['result']);

        $this->assertCount(1, $this->container);
        /** @var GuzzleHttp\Psr7\Request $httpRequest */
        $httpRequest = $this->container[0]['request'];
        $this->assertEquals('POST', $httpRequest->getMethod());
        $this->assertEquals('https://secure.platononline.com/post-unq/', (string)$httpRequest->getUri());

        parse_str((string)$httpRequest->getBody(), $body);
        $this->assertEquals([
            'action' => 'SALE',
            'client_key' => 'key',
            'order_id' => '1-1700000000',
            'order_amount' => '100.50',
            'order_currency' => 'UAH',
            'order_description' => 'description',
            'card_token' => 'token',
            'payer_email' => 'payer@example.com',
            'payer_phone' => '380930000000',
            'term_url_3ds' => 'https://example.com/',
            'channel_id' => 'rec',
            'hash' => md5(strtoupper(strrev('payer@example.com') . 'pass' . strrev('token'))),
            'ext1' => 'one',
            'ext2' => 'two',
            'ext3' => 'recurring',
        ], $body);
    }
}
