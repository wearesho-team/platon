<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Info;

use GuzzleHttp;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Info\Config;
use Wearesho\Bobra\Platon\Info\Repository;

/**
 * Class RepositoryTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Info
 */
class RepositoryTest extends TestCase
{
    /** @var GuzzleHttp\Handler\MockHandler */
    protected $mock;

    /** @var array[] */
    protected $history;

    /** @var Repository */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->history = [];
        $this->mock = new GuzzleHttp\Handler\MockHandler();
        $history = GuzzleHttp\Middleware::history($this->history);
        $stack = new GuzzleHttp\HandlerStack($this->mock);
        $stack->push($history);

        $this->repository = new Repository(
            new Config('public', 'private'),
            new GuzzleHttp\Client([
                'handler' => $stack,
            ])
        );
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Info\InvalidResponseException
     * @expectedExceptionMessage Missing keys in response
     * @expectedExceptionCode 1
     */
    public function testMissingData(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], '{}'));
        $this->repository->get(new \DateTime());
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Info\InvalidResponseException
     * @expectedExceptionMessage Missing keys in response
     * @expectedExceptionCode 1
     */
    public function testMissingSign(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'data' => [],
        ])));
        $this->repository->get();
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Info\InvalidResponseException
     * @expectedExceptionMessage Missing keys in response
     * @expectedExceptionCode 1
     */
    public function testMissingApiKey(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], json_encode([
            'data' => [],
            'sign' => '',
        ])));
        $this->repository->get();
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Info\InvalidResponseException
     * @expectedExceptionMessage Invalid api_key given
     * @expectedExceptionCode 2
     */
    public function testInvalidApiKey(): void
    {
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

    /**
     * @expectedException \Wearesho\Bobra\Platon\Info\InvalidResponseException
     * @expectedExceptionMessage Damaged data obtained
     * @expectedExceptionCode 3
     */
    public function testInvalidSign(): void
    {
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
