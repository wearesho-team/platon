<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Notification;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Config;
use Wearesho\Bobra\Platon\Notification;

/**
 * Class ConfigProviderTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Notification
 */
#[CoversClass(\Wearesho\Bobra\Platon\Notification\ConfigProvider::class)]
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
            'd2da8568431d02eb1296eb38f18eff7c'
        );
        $this->assertEquals($targetConfig->getPass(), $config->getPass());
    }

    public function testSuccessWithEmail(): void
    {
        $config = new Config('key', 'pass', 'CC');
        $provider = new Notification\ConfigProvider([$config]);

        // md5(strtoupper(strrev($email) . $pass . $order . strrev(first6 . last4))), as documented by Platon
        $targetConfig = $provider->provide(
            'order',
            '411111****1111',
            '334aeb5cce1357e5271c3701fcd27ac3',
            'john.doe@example.com'
        );
        $this->assertEquals($targetConfig->getPass(), $config->getPass());
    }

    public function testSuccessWithEmailSignedWithoutEmail(): void
    {
        $config = new Config('key', 'pass', 'CC');
        $provider = new Notification\ConfigProvider([$config]);

        $targetConfig = $provider->provide(
            'order',
            '411111****1111',
            '6ee9a37176e1859eb070aedcc4c6a937',
            'john.doe@example.com'
        );
        $this->assertEquals($targetConfig->getPass(), $config->getPass());
    }

    public function testSuccessUppercaseSign(): void
    {
        $config = new Config('key', 'pass', 'CC');
        $provider = new Notification\ConfigProvider([$config]);

        $targetConfig = $provider->provide(
            'order',
            '411111****1111',
            '6EE9A37176E1859EB070AEDCC4C6A937'
        );
        $this->assertEquals($targetConfig->getPass(), $config->getPass());
    }

    public function testSelectsConfigWhoseSignMatches(): void
    {
        $current = new Config('current', 'other', 'CC');
        $previous = new Config('previous', 'pass', 'CC');
        $provider = new Notification\ConfigProvider([$current, $previous]);

        $this->assertSame($previous, $provider->provide(
            'order',
            '411111****1111',
            '334aeb5cce1357e5271c3701fcd27ac3',
            'john.doe@example.com'
        ));
        $this->assertSame($current, $provider->provide(
            'order',
            '411111****1111',
            'da6edda8bc5c755d9da466ea86745a93',
            'john.doe@example.com'
        ));
    }

    public function testInvalidWithWrongEmail(): void
    {
        $provider = new Notification\ConfigProvider([new Config('key', 'pass', 'CC')]);

        $this->expectException(Notification\InvalidSignException::class);
        $provider->provide(
            'order',
            '411111****1111',
            '334aeb5cce1357e5271c3701fcd27ac3',
            'jane.doe@example.com'
        );
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
