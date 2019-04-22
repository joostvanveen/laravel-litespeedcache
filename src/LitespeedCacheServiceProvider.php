<?php

namespace Joostvanveen\LaravelLitespeedcache;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Joostvanveen\Litespeedcache\Cache as Litespeedcache;
use Joostvanveen\LaravelLitespeedcache\Middlewares\Cache as CacheMiddleware;

class LitespeedCacheServiceProvider extends ServiceProvider
{
    public function boot(\Illuminate\Routing\Router $router, \Illuminate\Contracts\Http\Kernel $kernel)
    {
        // Uncomment
        $router->aliasMiddleware('litespeedcache', CacheMiddleware::class);

        $this->publishes([
            __DIR__ . '/../config/litespeedcache.php' => config_path('litespeedcache.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/litespeedcache.php', 'litespeedcache');

        $this->app->bind('litespeedcache', function () {
            // New Joostvanveen\Litespeedcache\Cache, including default values from config
            return (new Litespeedcache)
                ->setEnabled(config('litespeedcache.defaults.enabled'))
                ->setType(config('litespeedcache.defaults.type'))
                ->setLifetime(config('litespeedcache.defaults.lifetime'));
        });
    }
}
