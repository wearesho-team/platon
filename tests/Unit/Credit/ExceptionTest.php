<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Credit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments\Credit\Transfer;
use Wearesho\Bobra\Platon;

/**
 * Class ExceptionTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Credit
 */
class ExceptionTest extends TestCase
{
    public function testConstruct(): void
    {
        $transfer = new Transfer(1, 10, 'cardToken');
        $response = new Platon\Credit\Response([
            'result' => Platon\Credit\Response\Result::SUCCESS,
        ]);
        $message = 'Exception Message';

        $exception = new Platon\Credit\Exception($transfer, $response, $message);

        $this->assertEquals(
            $transfer,
            $exception->getTransfer()
        );
        $this->assertEquals(
            $response,
            $exception->getResponse()
        );
        $this->assertEquals(
            $message,
            $exception->getMessage()
        );
    }
}
