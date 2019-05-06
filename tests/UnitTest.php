<?php

namespace Joostvanveen\LaravelLitespeedcache\Tests;

use LitespeedCache;

class UnitTest extends TestCase
{
    /** @test */
    public function config_contains_enabled()
    {
        $config = include(__DIR__ . '/../config/litespeedcache.php');
        $this->assertArrayHasKey('enabled', $config['defaults']);
    }

    /** @test */
    public function config_contains_type()
    {
        $config = include(__DIR__ . '/../config/litespeedcache.php');
        $this->assertArrayHasKey('type', $config['defaults']);
    }

    /** @test */
    public function config_contains_lifetime()
    {
        $config = include(__DIR__ . '/../config/litespeedcache.php');
        $this->assertArrayHasKey('lifetime', $config['defaults']);
    }
}
