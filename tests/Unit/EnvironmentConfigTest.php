<?php

namespace Wearesho\Bobra\Platon\Tests\Unit;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\EnvironmentConfig;

class EnvironmentConfigTest extends TestCase
{
    protected EnvironmentConfig $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new EnvironmentConfig();
    }

    public function testGetUrl()
    {
        $this->assertEquals(
            "https://secure.platononline.com/",
            $this->config->getBaseUrl()
        );
    }

    public function testGetKey()
    {
        putenv("PLATON_KEY=maza_faqa");

        $this->assertEquals(
            "maza_faqa",
            $this->config->getKey()
        );
    }

    public function testGetKeyException()
    {
        $this->expectException(MissingEnvironmentException::class);
        putenv("PLATON_KEY");
        $this->config->getKey();
    }

    public function testGetPass()
    {
        putenv("PLATON_PASS=fqn228sht");
        $this->assertEquals(
            "fqn228sht",
            $this->config->getPass()
        );
    }

    public function testGetPassException()
    {
        $this->expectException(MissingEnvironmentException::class);
        putenv("PLATON_PASS");
        $this->config->getPass();
    }

    public function testGetLanguage()
    {
        $this->assertEquals(
            "uk",
            $this->config->getLanguage()
        );
    }

    public function testGetPayment()
    {
        $this->assertEquals(
            "CC",
            $this->config->getPayment()
        );
    }
}
