<?php

namespace Wearesho\Bobra\Platon\Tests\Unit;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\EnvironmentConfig;

class EnvironmentConfigTest extends TestCase
{
    /** @var EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new EnvironmentConfig();
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
        putenv("PLATON_KEY=maza_faqa");

        $this->assertEquals(
            "maza_faqa",
            $this->config->getKey()
        );
    }

    /**
     * @expectedException \Horat1us\Environment\MissingEnvironmentException
     */
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

    /**
     * @expectedException \Horat1us\Environment\MissingEnvironmentException
     */
    public function testGetPassException()
    {
        $this->expectException(MissingEnvironmentException::class);
        putenv("PLATON_PASS");
        $this->config->getPass();
    }

    public function testGetLanguage()
    {
        $this->assertEquals(
            "ua",
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
