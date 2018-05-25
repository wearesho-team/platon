<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Notification;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Config;
use Wearesho\Bobra\Platon\Notification;

/**
 * Class ServerTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Notification
 */
class ServerTest extends TestCase
{
    /** @var Config */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Config('Test key', 'test', 'CC');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Key order is required
     */
    public function testMissingOrder(): void
    {
        $data = [
            'sign' => 'test',
        ];

        $server = new Notification\Server($this->config);
        $server->handle($data);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Key card is required
     */
    public function testMissingCard(): void
    {
        $data = [
            'sign' => 'test',
            'order' => 'test',
        ];

        $server = new Notification\Server($this->config);
        $server->handle($data);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid sign
     */
    public function testInvalidSign(): void
    {
        $data = [
            'sign' => 'invalid sign',
            'order' => 'test',
            'card' => 'test',
        ];

        $server = new Notification\Server($this->config);
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
            'status' => Notification\Payment::STATUS_SALE,
            'amount' => mt_rand(100, 500),
            'currency' => 'UAH',
        ];

        $server = new Notification\Server($this->config);
        $payment = $server->handle($data);
        $this->assertInstanceOf(Notification\Payment::class, $payment);
    }
}
