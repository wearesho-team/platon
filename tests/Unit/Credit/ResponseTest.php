<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Credit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Credit\Response;

/**
 * Class ResponseTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Credit
 * @coversDefaultClass \Wearesho\Bobra\Platon\Credit\Response
 */
class ResponseTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Response Array have to contain result key
     */
    public function testMissingResult(): void
    {
        new Response([]);
    }

    public function testSuccessful(): void
    {
        $response = new Response(['result' => 'SUCCESS',]);
        $this->assertEquals('SUCCESS', $response->getResult());
        $this->assertTrue($response->isSuccessful());
    }

    public function testUnsuccessful(): void
    {
        $response = new Response(['result' => 'FAIL',]);
        $this->assertEquals('FAIL', $response->getResult());
        $this->assertFalse($response->isSuccessful());
    }

    public function testNotWaiting(): void
    {
        $response = new Response(['result' => Response\Result::SUCCESS,]);
        $this->assertFalse($response->isWaiting());

        $response = new Response(['result' => Response\Result::SUCCESS, 'status' => 'unknown',]);
        $this->assertFalse($response->isWaiting());
    }

    public function testWaiting(): void
    {
        $response = new Response(['result' => Response\Result::SUCCESS, 'status' => Response\Status::WAITING,]);
        $this->assertTrue($response->isWaiting());
    }
}
