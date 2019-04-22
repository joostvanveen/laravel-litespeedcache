<?php

namespace Joostvanveen\LaravelLitespeedcache\Tests;

use LitespeedCache;

class FeatureTest extends TestCase
{

    /**
     * @test
     * @runInSeparateProcess
     */
    public function it_can_cache()
    {
        LitespeedCache::setUnitTestMode()
                      ->setEnabled(true)
                      ->setType('private')
                      ->setLifetime(60)
                      ->cache();

        $headers = $this->getHeaders();
        $this->assertTrue(in_array('X-LiteSpeed-Cache-Control: private, max-age=60', $headers));
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function it_uses_config_values()
    {
        $config = include(__DIR__ . '/../config/litespeedcache.php');

        LitespeedCache::setUnitTestMode()->cache();

        $headers = $this->getHeaders();
        $this->assertTrue(in_array('X-LiteSpeed-Cache-Control: ' . $config['defaults']['type'] . ', max-age=' . $config['defaults']['lifetime'] . '', $headers));
    }
}
