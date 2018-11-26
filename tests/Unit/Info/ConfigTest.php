<?php

namespace Wearesho\Bobra\Platon\Tests\Unit\Info;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Info\Config;

/**
 * Class ConfigTest
 * @package Wearesho\Bobra\Platon\Tests\Unit\Info
 */
class ConfigTest extends TestCase
{
    public function testGetters(): void
    {
        $config = new Config('public', 'private');
        $this->assertEquals('public', $config->getPublicKey());
        $this->assertEquals('private', $config->getPrivateKey());
        $this->assertEquals('http://62.113.194.121/', $config->getBaseUrl());
        $config = new Config('', '', 'http://google.com');
        $this->assertEquals('http://google.com', $config->getBaseUrl());
    }
}
