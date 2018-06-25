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
        $config = new Config('key', 'pass', 'CC');
        $provider = new Notification\ConfigProvider([$config]);

        $targetConfig = $provider->provide(
            'order',
            '411111****1111',
            '6ee9a37176e1859eb070aedcc4c6a937'
        );
        $this->assertEquals($targetConfig->getPass(), $config->getPass());
    }

    public function testSuccessDebit(): void
    {
        $config = new Config('key', 'pass', 'CC');
        $provider = new Notification\ConfigProvider([$config]);

        $targetConfig = $provider->provide(
            'order',
            '411111****1111',
            '6ee9a37176e1859eb070aedcc4c6a937'
        );
        $this->assertEquals($targetConfig->getPass(), $config->getPass());
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Notification\InvalidSignException
     */
    public function testEmpty(): void
    {
        $provider = new Notification\ConfigProvider();
        $provider->provide('order', 'card', 'sign');
    }

    /**
     * @expectedException \Wearesho\Bobra\Platon\Notification\InvalidSignException
     */
    public function testMissing(): void
    {
        $provider = new Notification\ConfigProvider([
            new Config('test', 'test', 'CC'),
        ]);
        $provider->provide('order', 'invalidPass', 'invalidSign');
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
