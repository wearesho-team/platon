<?php

namespace Wearesho\Bobra\Platon\Tests;

use Wearesho\Bobra\Platon;
use PHPUnit\Framework\TestCase;

/**
 * Class TransactionTest
 * @package Wearesho\Bobra\Platon\Tests
 */
class TransactionTest extends TestCase
{
    public function testFormId()
    {
        $transaction = new Platon\Transaction(
            1,
            20,
            'type',
            'Description',
            [],
            'UAH',
            'FormId'
        );

        $this->assertEquals($transaction->getFormId(), 'FormId');
        $this->assertEquals(
            '{"id":1,"amount":2000,"type":"type","description":"Description","info":[],"currency":"UAH","formId":"FormId"}', // phpcs:ignore
            json_encode($transaction)
        );
    }
}
