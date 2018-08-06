<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Credit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Credit;

/**
 * Class CardTransferTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Credit
 */
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

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid expire month 0 passed
     */
    public function testLowMonth(): void
    {
        new Credit\CardTransfer(1, 100, '', 0, 18);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid expire month 13 passed
     */
    public function testBigMonth(): void
    {
        new Credit\CardTransfer(1, 100, '', 13, 18);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid expire year 17 passed
     */
    public function testLowYear(): void
    {
        new Credit\CardTransfer(1, 100, '', 1, 17);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid expire year 50 passed
     */
    public function testBigYear(): void
    {
        new Credit\CardTransfer(1, 100, '', 1, 50);
    }
}
