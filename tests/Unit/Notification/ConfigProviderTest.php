<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Notification;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Config;
use Wearesho\Bobra\Platon\Notification;

/**
 * Class ConfigProviderTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Notification
 * @coversDefaultClass \Wearesho\Bobra\Platon\Notification\ConfigProvider
 */
class ConfigProviderTest extends TestCase
{
    public function testSuccess(): void
    {
        $config = new Config('test', 'test pass', '');
        $provider = new Notification\ConfigProvider([$config]);
        $targetConfig = $provider->provide($config->getKey());
        $this->assertEquals($targetConfig->getPass(), $config->getPass());
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Notification\UnsupportedMerchantException
     */
    public function testMissing(): void
    {
        $provider = new Notification\ConfigProvider();
        $provider->provide('missed key');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage All configs have to implement Wearesho\Bobra\Platon\ConfigInterface
     */
    public function testInvalidParam(): void
    {
        new Notification\ConfigProvider([1]);
    }
}
