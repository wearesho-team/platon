<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\ConfigInterface;
use Wearesho\Bobra\Platon\LanguageConfigTrait;

class LanguageConfigTraitTest extends TestCase
{
    public function testMethods()
    {
        $config = new class
        {
            use LanguageConfigTrait;
        };

        $this->assertEquals(ConfigInterface::LANGUAGE_UA, $config->getLanguage(), "Default Language");

        $config->setLanguage(ConfigInterface::LANGUAGE_RU);
        $this->assertEquals(ConfigInterface::LANGUAGE_RU, $config->getLanguage());
    }

    public function testInvalidLangException()
    {
        $config = new class
        {
            use LanguageConfigTrait;
        };

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid language");
        $config->setLanguage("qwerty");
    }
}
