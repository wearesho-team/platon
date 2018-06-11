<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Notification;

use Carbon\Carbon;
use Wearesho\Bobra\Platon\Notification\Payment;
use PHPUnit\Framework\TestCase;

/**
 * Class PaymentTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Notification
 * @coversDefaultClass \Wearesho\Bobra\Platon\Payment
 */
class PaymentTest extends TestCase
{
    /** @var Payment */
    protected $payment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payment = new Payment(
            'test',
            'test',
            'test',
            100,
            'UAH',
            Payment\Status::SALE,
            '411111****1111',
            Carbon::parse(Carbon::now()->toDateString()),
            'test',
            [
                'ext1' => 'test',
            ]
        );
    }

    public function testGetStatus(): void
    {
        $this->assertEquals(Payment\Status::SALE, $this->payment->getStatus());
    }

    public function testGetId(): void
    {
        $this->assertEquals('test', $this->payment->getId());
    }

    public function testGetOrderId(): void
    {
        $this->assertEquals('test', $this->payment->getOrderId());
    }

    public function testGetCard(): void
    {
        $this->assertEquals('411111****1111', $this->payment->getCard());
    }

    public function testGetCurrency(): void
    {
        $this->assertEquals('UAH', $this->payment->getCurrency());
    }

    public function testGetAmount(): void
    {
        $this->assertEquals(100, $this->payment->getAmount());
    }

    public function testGetRcToken(): void
    {
        $this->assertEquals('test', $this->payment->getRcToken());
    }

    public function testGetDate(): void
    {
        $this->assertEquals(Carbon::now()->toDateString(), $this->payment->getDate()->format('Y-m-d'));
    }

    public function testGetData(): void
    {
        $data = $this->payment->getData();
        $this->assertArrayHasKey('ext1', $data);
        $this->assertEquals('test', $data['ext1']);
    }

    public function testGetKey(): void
    {
        $this->assertEquals('test', $this->payment->getKey());
    }

    public function testEmptyRcToken(): void
    {
        $this->payment = new Payment(
            'test',
            'test',
            'test',
            100,
            'UAH',
            Payment\Status::SALE,
            '411111****1111',
            Carbon::parse(Carbon::now()->toDateString()),
            null,
            [
                'ext1' => 'test',
            ]
        );

        $this->assertNull($this->payment->getRcToken());
    }
}
