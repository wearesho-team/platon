<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Notification;

use Carbon\CarbonTimeZone;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Config;
use Wearesho\Bobra\Platon\Notification;

/**
 * Class ServerTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Notification
 * @coversDefaultClass \Wearesho\Bobra\Platon\Notification\Server
 */
class ServerTest extends TestCase
{
    protected const KEY = 'test key';

    /** @var Config */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Config(static::KEY, 'test', 'CC');
    }

    public function testMissingOrder(): void
    {
        $data = [
            'sign' => 'test',
        ];

        $server = new Notification\Server(
            new Notification\ConfigProvider([$this->config])
        );
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Key `order` is required');
        $server->handle($data);
    }

    public function testMissingCard(): void
    {
        $data = [
            'sign' => 'test',
            'order' => 'test',
        ];

        $server = new Notification\Server(
            new Notification\ConfigProvider([$this->config])
        );
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Key `card` is required');
        $server->handle($data);
    }

    public function testInvalidSign(): void
    {
        $data = [
            'sign' => 'invalid sign',
            'order' => 'test',
            'card' => 'test',
            'key' => static::KEY,
        ];

        $server = new Notification\Server(
            new Notification\ConfigProvider([$this->config])
        );
        $this->expectException(Notification\InvalidSignException::class);
        $server->handle($data);
    }

    public function testSuccess(): void
    {
        $data = [
            'sign' => '7e43d3c6dd1485a78b5d88e981f4cc72',
            'order' => 'order',
            'card' => '411111****1111',
            'id' => 'id',
            'date' => date('Y-m-d H:i:s'),
            'status' => Notification\Payment\Status::SALE,
            'amount' => mt_rand(100, 500),
            'currency' => 'UAH',
            'key' => static::KEY,
            'rc_token' => uniqid(),
            'ext1' => '2',
            'ext5' => '10',
            'ext10' => '20',
        ];

        $server = new Notification\Server(
            new Notification\ConfigProvider([$this->config])
        );
        $payment = $server->handle($data);
        $this->assertInstanceOf(Notification\Payment::class, $payment);
        $this->assertEquals(
            'UTC',
            $payment->getDate()->getTimezone()->getName()
        );
        $this->assertEquals($data, $payment->getBody());
        $this->assertEquals([
            'ext1' => '2',
            'ext5' => '10',
            'ext10' => '20',
        ], $payment->getData());
    }
}
