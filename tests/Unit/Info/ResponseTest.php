<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Info;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Info\Response;

class ResponseTest extends TestCase
{
    public function testPrivat(): void
    {
        $dateTime = new \DateTime();
        $response = new Response(
            'id',
            1,
            2,
            $dateTime,
            1000,
            2000
        );

        $this->assertEquals('id', $response->getId());
        $this->assertEquals(1, $response->getType());
        $this->assertEquals(2, $response->getAccount());
        $this->assertEquals($dateTime, $response->getLastOperation());
        $this->assertEquals(1000, $response->getOutcome());
        $this->assertEquals(2000, $response->getBalance());
        $this->assertEquals([], $response->getRaw());

        $this->assertEquals([
            'lastOperation' => $dateTime->format('Y-m-d H:i:s'),
            'id' => 'id',
            'type' => 1,
            'account' => 2,
            'outcome' => 1000,
            'balance' => 2000,
        ], $response->jsonSerialize());

        $this->assertEquals(
            implode("\n", [
                '************PRIVAT************',
                'Ключ = id',
                'Остаток = 2000',
                'Транзитный счет = 2',
                "Дата/время последней операции = {$dateTime->format('Y-m-d H:i:s')}",
                'Выплачено = 1000',
            ]),
            (string)$response
        );
    }

    public function testDiamant(): void
    {
        $dateTime = new \DateTime();
        $response = new Response(
            'id',
            2,
            2,
            $dateTime,
            1000,
            2000,
            ['key' => 'value',]
        );

        $this->assertEquals(['key' => 'value',], $response->getRaw());

        $this->assertEquals([
            'lastOperation' => $dateTime->format('Y-m-d H:i:s'),
            'id' => 'id',
            'type' => 2,
            'account' => 2,
            'outcome' => 1000,
            'balance' => 2000,
        ], $response->jsonSerialize());

        $this->assertEquals(
            implode("\n", [
                '************DIAMANT************',
                'Ключ = id',
                'Остаток = 2000',
                'Транзитный счет = 2',
                "Дата/время последней операции = {$dateTime->format('Y-m-d H:i:s')}",
                'Выплачено = 1000',
            ]),
            (string)$response
        );
    }
}
