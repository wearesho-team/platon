<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Credit\Response;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments\Credit\Transfer;
use Wearesho\Bobra\Platon\Credit\Response;

/**
 * Class ValidatorTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Credit\Response
 * @coversDefaultClass \Wearesho\Bobra\Platon\Credit\Response\Validator
 */
class ValidatorTest extends TestCase
{
    /** @var Response\Validator */
    protected $validator;

    /** @var Transfer */
    protected $transfer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new Response\Validator();
        $this->transfer = new Transfer(1, 100, '');
    }

    /**
     * @singe 1.5.1 this test expect Credit\Exception to be thrown instead of DuplicatedTransfer
     */
    public function testDuplicateRequest(): void
    {
        $this->expectException(\Wearesho\Bobra\Payments\Credit\Exception::class);
        $this->expectExceptionMessage('Duplicate request');
        $this->validator->validate(
            new Response([
                'result' => 'ERROR',
                'error_message' => 'Duplicate request',
            ]),
            $this->transfer
        );
    }

    public function testOrderExists(): void
    {
        $this->expectException(\Wearesho\Bobra\Payments\Credit\Exception\DuplicatedTransfer::class);
        $this->expectExceptionMessage('Order already exists');
        $this->validator->validate(
            new Response([
                'result' => 'ERROR',
                'error_message' => 'Order already exists',
            ]),
            $this->transfer
        );
    }

    public function testErrorWithCustomMessage(): void
    {
        $this->expectException(\Wearesho\Bobra\Platon\Credit\Exception::class);
        $this->expectExceptionMessage('Custom error message');
        $this->validator->validate(
            new Response([
                'result' => 'ERROR',
                'error_message' => 'Custom error message',
            ]),
            $this->transfer
        );
    }

    public function testInvalidCard(): void
    {
        $this->expectException(\Wearesho\Bobra\Payments\Credit\Exception\InvalidCardToken::class);
        $this->expectExceptionMessage('Invalid card');
        $this->validator->validate(
            new Response([
                'result' => 'DECLINED',
                'decline_reason' => 'Invalid card',
            ]),
            $this->transfer
        );
    }

    public function testDeclineWithCustomMessage(): void
    {
        $this->expectException(\Wearesho\Bobra\Platon\Credit\Exception::class);
        $this->expectExceptionMessage('Custom reason');
        $this->validator->validate(
            new Response([
                'result' => 'DECLINED',
                'decline_reason' => 'Custom reason',
            ]),
            $this->transfer
        );
    }

    public function testUnknownResult(): void
    {
        $this->expectException(\Wearesho\Bobra\Platon\Credit\Exception::class);
        $this->expectExceptionMessage('Unknown result: unknown');
        $this->validator->validate(
            new Response([
                'result' => 'unknown',
            ]),
            $this->transfer
        );
    }
}
