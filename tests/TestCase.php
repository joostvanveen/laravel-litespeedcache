<?php

namespace Joostvanveen\LaravelLitespeedcache\Tests;

use Joostvanveen\LaravelLitespeedcache\Facades\LitespeedCache;
use Joostvanveen\LaravelLitespeedcache\LitespeedCacheServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{

    /**
     * Load package service provider
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return Joostvanveen\LaravelLitespeedcache\LitespeedCacheServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [LitespeedCacheServiceProvider::class];
    }

    /**
     * Load package alias
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'LitespeedCache' => LitespeedCache::class,
        ];
    }

    protected function getHeaders()
    {
        if (! function_exists('xdebug_get_headers')) {
            throw new \Exception('function xdebug_get_headers() does not exist. Please activate Xdebug');
        }

        return xdebug_get_headers();
    }
}
