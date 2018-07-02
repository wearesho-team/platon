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
     * @expectedException \Wearesho\Bobra\Payments\Credit\Exception\DuplicatedTransfer
     * @expectedExceptionMessage Order already exists
     */
    public function testDuplicateRequest(): void
    {
        $this->validator->validate(
            new Response([
                'result' => 'ERROR',
                'error_message' => 'Order already exists',
            ]),
            $this->transfer
        );
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Credit\Exception
     * @expectedExceptionMessage Custom error message
     */
    public function testErrorWithCustomMessage(): void
    {
        $this->validator->validate(
            new Response([
                'result' => 'ERROR',
                'error_message' => 'Custom error message',
            ]),
            $this->transfer
        );
    }

    /**
     * @expectedException \Wearesho\Bobra\Payments\Credit\Exception\InvalidCardToken
     * @expectedExceptionMessage Invalid card
     */
    public function testInvalidCard(): void
    {
        $this->validator->validate(
            new Response([
                'result' => 'DECLINED',
                'decline_reason' => 'Invalid card',
            ]),
            $this->transfer
        );
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Credit\Exception
     * @expectedExceptionMessage Custom reason
     */
    public function testDeclineWithCustomMessage(): void
    {
        $this->validator->validate(
            new Response([
                'result' => 'DECLINED',
                'decline_reason' => 'Custom reason',
            ]),
            $this->transfer
        );
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Credit\Exception
     * @expectedExceptionMessage Unknown result
     */
    public function testUnknownResult(): void
    {
        $this->validator->validate(
            new Response([
                'result' => 'Unknown result',
            ]),
            $this->transfer
        );
    }
}
