<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Info;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Info\InvalidResponseException;

class InvalidResponseExceptionTest extends TestCase
{
    public function testGetBody(): void
    {
        $exception = new InvalidResponseException('Exception message', 0, ['key' => 'value',]);
        $this->assertEquals(['key' => 'value',], $exception->getBody());
        $this->assertStringStartsWith(
            'Wearesho\Bobra\Platon\Info\InvalidResponseException: Exception message',
            (string)$exception
        );
        $this->assertStringEndsWith(PHP_EOL . 'Body: {"key":"value"}', (string)$exception);
    }
}
