<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon;

/**
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

    public function testInvalidLanguage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid language');
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
