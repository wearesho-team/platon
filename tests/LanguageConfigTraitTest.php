<?php

namespace Wearesho\Bobra\Platon\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\ConfigInterface;
use Wearesho\Bobra\Platon\LanguageConfigTrait;

/**
 * Class LanguageConfigTraitTest
 * @package Wearesho\Bobra\Platon\Tests
 */
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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidLangException()
    {
        $config = new class
        {
            use LanguageConfigTrait;
        };

        $config->setLanguage("qwerty");
        $this->expectExceptionMessage("Invalid language");
    }
}
