<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Credit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Credit;

class CardTransferTest extends TestCase
{
    public function testCorrect(): void
    {
        $year = (int)Carbon::now()->format('y');
        $transfer = new Credit\CardTransfer(
            1,
            100,
            '4111111111111111',
            1,
            $year
        );
        $this->assertEquals(1, $transfer->getExpireMonth());
        $this->assertEquals($year, $transfer->getExpireYear());
    }

    public function testLowMonth(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid expire month 0 passed');
        new Credit\CardTransfer(1, 100, '', 0, 18);
    }

    public function testBigMonth(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid expire month 13 passed');
        new Credit\CardTransfer(1, 100, '', 13, 18);
    }

    public function testLowYear(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid expire year 17 passed');
        new Credit\CardTransfer(1, 100, '', 1, 17);
    }

    public function testBigYear(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid expire year 50 passed');
        new Credit\CardTransfer(1, 100, '', 1, 50);
    }
}
