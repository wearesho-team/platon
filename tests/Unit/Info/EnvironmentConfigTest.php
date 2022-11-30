<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Tests\Unit\Info;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Platon\Info\EnvironmentConfig;

class EnvironmentConfigTest extends TestCase
{
    public function testGetters(): void
    {
        putenv('PLATON_INFO_PUBLIC_KEY=public');
        putenv('PLATON_INFO_PRIVATE_KEY=private');
        $config = new EnvironmentConfig();
        $this->assertEquals('public', $config->getPublicKey());
        $this->assertEquals('private', $config->getPrivateKey());
        $this->assertEquals('http://62.113.194.121/', $config->getBaseUrl());
        putenv('PLATON_INFO_BASE_URL=http://google.com');
        $this->assertEquals('http://google.com', $config->getBaseUrl());
    }
}
