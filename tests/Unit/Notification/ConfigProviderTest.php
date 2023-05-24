<?php

declare(strict_types=1);

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

    public function testSuccessDebitWithEmail(): void
    {
        $config = new Config('key', 'pass', 'CC');
        $provider = new Notification\ConfigProvider([$config]);

        $targetConfig = $provider->provide(
            'order',
            '411111****1111',
            'fc0c63b436e7b63efc5a33bd5a5b7827',
             'john.doe@example.com'
        );
        $this->assertEquals($targetConfig->getPass(), $config->getPass());
    }

    public function testEmpty(): void
    {
        $provider = new Notification\ConfigProvider();
        $this->expectException(\Wearesho\Bobra\Platon\Notification\InvalidSignException::class);
        $provider->provide('order', 'card', 'sign');
    }

    public function testMissing(): void
    {
        $provider = new Notification\ConfigProvider([
            new Config('test', 'test', 'CC'),
        ]);
        $this->expectException(\Wearesho\Bobra\Platon\Notification\InvalidSignException::class);
        $provider->provide('order', 'invalidPass', 'invalidSign');
    }

    public function testInvalidParam(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('All configs have to implement Wearesho\Bobra\Platon\ConfigInterface');
        /** @noinspection PhpParamsInspection */
        new Notification\ConfigProvider([1]);
    }
}
