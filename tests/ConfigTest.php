<?php

namespace Wearesho\Bobra\Platon\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Config;

class ConfigTest extends TestCase
{
    /** @var Config */
    protected $config;

    protected function setUp():void
    {
        parent::setUp();
        $this->config = new Config("key_string_global", "pass_string_global", "payment_string_global");
    }

    public function testConstruct()
    {
        $configObject = new Config(
            "key_string",
            "pass_string",
            "payment_string"
        );

        $this->assertEquals(
            "https://secure.platononline.com/payment/auth",
            $configObject->getUrl()
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

    public function testGetUrl()
    {
        $this->assertEquals(
            "https://secure.platononline.com/payment/auth",
            $this->config->getUrl()
        );
    }

    public function testGetKey()
    {
        $this->assertEquals(
            "key_string_global",
            $this->config->getKey()
        );
    }

    public function testGetPass()
    {
        $this->assertEquals(
            "pass_string_global",
            $this->config->getPass()
        );
    }

    public function testGetPayment()
    {
        $this->assertEquals(
            "payment_string_global",
            $this->config->getPayment()
        );
    }
}
