<?php

namespace Joostvanveen\LaravelLitespeedcache;

use Illuminate\Support\ServiceProvider;
use Joostvanveen\LaravelLitespeedcache\Middlewares\Cache as CacheMiddleware;
use Joostvanveen\Litespeedcache\Cache as Litespeedcache;
use Joostvanveen\Litespeedcache\Http\Controllers\LitespeedCacheController;

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

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }

    public function register()
    {
        require_once(__DIR__ . '/Helpers/litespeedHelpers.php');

        $this->mergeConfigFrom(__DIR__ . '/../config/litespeedcache.php', 'litespeedcache');

        // Bind new Joostvanveen\Litespeedcache\Cache, including default values from config
        $this->app->singleton('litespeedcache', function () {
            return (new Litespeedcache)
                ->setEnabled(config('litespeedcache.defaults.enabled'))
                ->setEsiEnabled(config('litespeedcache.defaults.esiEnabled'))
                ->setType(config('litespeedcache.defaults.type'))
                ->setEnableAjaxCache(config('litespeedcache.defaults.enable_ajax_cache'))
                ->setCacheableHttpVerbs(config('litespeedcache.defaults.cache_http_verbs'))
                ->setLifetime(config('litespeedcache.defaults.lifetime'))
                ->setExcludedUrls(config('litespeedcache.defaults.excludedUris'))
                ->setExcludedQueryStrings(config('litespeedcache.defaults.excludedQueryStrings'));
        });
    }
}
