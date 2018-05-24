<?php

namespace Wearesho\Bobra\Platon\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon;

/**
 * Class LanguageTransactionTest
 * @package Wearesho\Bobra\Platon\Tests
 * @coversDefaultClass \Wearesho\Bobra\Platon\LanguageTransaction
 */
class LanguageTransactionTest extends TestCase
{
    public function testLanguage(): void
    {
        $transaction = new Platon\LanguageTransaction(
            1,
            200,
            'type',
            'Description',
            [],
            'UAH',
            null,
            Platon\ConfigInterface::LANGUAGE_RU
        );
        $this->assertEquals(Platon\ConfigInterface::LANGUAGE_RU, $transaction->getLanguage());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid language
     */
    public function testInvalidLanguage(): void
    {
        new Platon\LanguageTransaction(
            1,
            200,
            'type',
            'Description',
            [],
            'UAH',
            null,
            'invalidLanguage'
        );
    }
}
