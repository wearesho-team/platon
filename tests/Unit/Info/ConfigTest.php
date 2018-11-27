<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Info;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon;

/**
 * Class ConfigTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Info
 */
class ConfigTest extends TestCase
{
    protected const TEST_PUBLIC_KEY = 'publicKey';
    protected const TEST_PRIVATE_KEY = 'privateKey';
    protected const TEST_BASE_URL = Platon\Info\ConfigInterface::DEFAULT_BASE_URL;

    /** @var Platon\Info\Config */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Platon\Info\Config(
            static::TEST_PUBLIC_KEY,
            static::TEST_PRIVATE_KEY,
            static::TEST_BASE_URL
        );
    }

    public function testGetPublicKey(): void
    {
        $this->assertEquals(
            static::TEST_PUBLIC_KEY,
            $this->config->getPublicKey()
        );
    }

    public function testGetPrivateKey(): void
    {
        $this->assertEquals(
            static::TEST_PRIVATE_KEY,
            $this->config->getPrivateKey()
        );
    }

    public function testGetBaseUrl(): void
    {
        $this->assertEquals(
            static::TEST_BASE_URL,
            $this->config->getBaseUrl()
        );
    }
}
