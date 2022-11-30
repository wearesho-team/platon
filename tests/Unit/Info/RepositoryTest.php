<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Info;

use GuzzleHttp;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Info;

class RepositoryTest extends TestCase
{
    protected GuzzleHttp\Handler\MockHandler $mock;

    /** @var array[] */
    protected array $history;

    protected Info\Repository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->history = [];
        $this->mock = new GuzzleHttp\Handler\MockHandler();
        $history = GuzzleHttp\Middleware::history($this->history);
        $stack = new GuzzleHttp\HandlerStack($this->mock);
        $stack->push($history);

        $this->repository = new Info\Repository(
            new Info\Config('public', 'private'),
            new GuzzleHttp\Client([
                'handler' => $stack,
            ])
        );
    }

    public function testMissingData(): void
    {
        $this->expectException(Info\InvalidResponseException::class);
        $this->expectExceptionMessage('Missing keys in response');
        $this->expectExceptionCode(1);
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], '{}'));
        $this->repository->get(new \DateTime());
    }

    public function testMissingSign(): void
    {
        $this->expectException(Info\InvalidResponseException::class);
        $this->expectExceptionMessage('Missing keys in response');
        $this->expectExceptionCode(1);
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'data' => [],
        ])));
        $this->repository->get();
    }

    public function testMissingApiKey(): void
    {
        $this->expectException(Info\InvalidResponseException::class);
        $this->expectExceptionMessage('Missing keys in response');
        $this->expectExceptionCode(1);
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'data' => [],
            'sign' => '',
        ])));
        $this->repository->get();
    }

    public function testInvalidApiKey(): void
    {
        $this->expectException(Info\InvalidResponseException::class);
        $this->expectExceptionMessage('Invalid api_key given');
        $this->expectExceptionCode(2);
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'data' => [],
            'sign' => '',
            'api_key' => '',
        ])));
        $this->repository->get();
    }

    public function testEmptyBodyData(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'data' => [],
            'sign' => '',
            'api_key' => 'public',
        ])));
        $this->assertEquals([], $this->repository->get());
    }

    public function testInvalidSign(): void
    {

        $this->expectException(Info\InvalidResponseException::class);
        $this->expectExceptionMessage('Damaged data obtained');
        $this->expectExceptionCode(3);
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'data' => [[],],
            'sign' => '',
            'api_key' => 'public',
        ])));

        $this->repository->get();
    }

    public function testSuccessResponses(): void
    {

        $statistics = [
            'id' => 'id',
            'type' => 2,
            'date' => '2018-01-01 00:00:00',
            'outcome' => '2&nbsp;000,5',
            'sum' => '1&nbsp;000',
        ];

        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'data' => [1 => $statistics],
            'sign' => hash('sha256', implode($statistics) . 'private'),
            'api_key' => 'public',
        ])));
        $responses = $this->repository->get();
        $this->assertEquals(1, count($responses));
        $response = $responses[0];

        $this->assertEquals(1000, $response->getBalance());
        $this->assertEquals(2000.5, $response->getOutcome());
    }
}
