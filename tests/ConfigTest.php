<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Config;

class ConfigTest extends TestCase
{
    protected Config $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Config("key_string_global", "pass_string_global", "payment_string_global");
    }

    public function testConstruct(): void
    {
        $configObject = new Config(
            "key_string",
            "pass_string",
            "payment_string"
        );

        $this->assertEquals(
            "key_string",
            $configObject->getKey()
        );

        $this->assertEquals(
            "pass_string",
            $configObject->getPass()
        );

        $this->assertEquals(
            "payment_string",
            $configObject->getPayment()
        );
    }

    public function testGetUrl(): void
    {
        $this->assertEquals(
            "https://secure.platononline.com/",
            $this->config->getBaseUrl()
        );
    }

    public function testGetKey(): void
    {
        $this->assertEquals(
            "key_string_global",
            $this->config->getKey()
        );
    }

    public function testGetPass(): void
    {
        $this->assertEquals(
            "pass_string_global",
            $this->config->getPass()
        );
    }

    public function testGetPayment(): void
    {
        $this->assertEquals(
            "payment_string_global",
            $this->config->getPayment()
        );
    }
}
