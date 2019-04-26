<?php

namespace Joostvanveen\LaravelLitespeedcache;

use Illuminate\Support\ServiceProvider;
use Joostvanveen\LaravelLitespeedcache\Middlewares\Cache as CacheMiddleware;
use Joostvanveen\Litespeedcache\Cache as Litespeedcache;

class LitespeedCacheServiceProvider extends ServiceProvider
{

    public function boot(\Illuminate\Routing\Router $router, \Illuminate\Contracts\Http\Kernel $kernel)
    {
        // Add default middleware if enabled
        if (config('litespeedcache.defaults.use_middleware')) {
            $router->aliasMiddleware('litespeedcache', CacheMiddleware::class);
            $kernel->pushMiddleware(CacheMiddleware::class);
        }

        // Publish config settings
        $this->publishes([
            __DIR__ . '/../config/litespeedcache.php' => config_path('litespeedcache.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/litespeedcache.php', 'litespeedcache');

        // Bind new Joostvanveen\Litespeedcache\Cache, including default values from config
        $this->app->bind('litespeedcache', function () {
            return (new Litespeedcache)
                ->setEnabled(config('litespeedcache.defaults.enabled'))
                ->setType(config('litespeedcache.defaults.type'))
                ->setLifetime(config('litespeedcache.defaults.lifetime'))
                ->setExcludedUrls(config('litespeedcache.defaults.excludedUris'))
                ->setExcludedQueryStrings(config('litespeedcache.defaults.excludedQueryStrings'));
        });
    }
}
