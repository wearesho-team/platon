<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Credit;

use Wearesho\Bobra\Platon\Credit\CreditToCard;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Wearesho\Bobra\Platon\Credit\CreditToCard
 */
class CreditToCardTest extends TestCase
{
    protected CreditToCard $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new CreditToCard(
            1,
            100,
            '11111111111111111111111111111111',
            'test',
            'UAH'
        );
    }

    public function testGetCurrency(): void
    {
        $this->assertEquals('UAH', $this->model->getCurrency());
    }

    public function testGetId(): void
    {
        $this->assertEquals(1, $this->model->getId());
    }

    public function testGetAmount(): void
    {
        $this->assertEquals(100, $this->model->getAmount());
    }

    public function testGetCardToken(): void
    {
        $this->assertEquals('11111111111111111111111111111111', $this->model->getCardToken());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals('test', $this->model->getDescription());
    }
}
