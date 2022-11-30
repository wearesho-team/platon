<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Credit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Credit\Response;

/**
 * @coversDefaultClass \Wearesho\Bobra\Platon\Credit\Response
 */
class ResponseTest extends TestCase
{
    public function testMissingResult(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Response Array have to contain result key');
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
