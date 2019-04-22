<?php

namespace Joostvanveen\LaravelLitespeedcache;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LitespeedCacheServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('litespeedcache', function () {
            return new \Joostvanveen\Litespeedcache\Cache;
        });
    }
}
