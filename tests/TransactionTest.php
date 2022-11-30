<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests;

use Wearesho\Bobra\Platon;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testFormId(): void
    {
        $transaction = new Platon\Transaction(
            1,
            2.28,
            'type',
            'Description',
            [],
            'UAH',
            'FormId'
        );

        $this->assertEquals($transaction->getFormId(), 'FormId');
        $this->assertEquals(
            '{"id":1,"amount":228,"type":"type","description":"Description","info":[],"currency":"UAH","formId":"FormId"}', // phpcs:ignore
            json_encode($transaction)
        );
        $this->assertEquals(228, $transaction->getAmount());
    }

    public function testCardToken(): void
    {
        $transaction = new Platon\Transaction(
            1,
            2.28,
            'type',
            'Description',
            [],
            'UAH',
            null,
            "CardToken"
        );
        $this->assertEquals(
            $transaction->getCardToken(),
            "CardToken"
        );
        $this->assertEquals(
            '{"id":1,"amount":228,"type":"type","description":"Description","info":[],"currency":"UAH","cardToken":"CardToken"}', // phpcs:ignore
            json_encode($transaction)
        );
    }
}
