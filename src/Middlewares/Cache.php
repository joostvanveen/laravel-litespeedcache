<?php

namespace Joostvanveen\LaravelLitespeedcache\Middlewares;

use Closure;
use Joostvanveen\LaravelLitespeedcache\Facades\LitespeedCache;

class Cache
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // New Joostvanveen\Litespeedcache\Cache, including default values from config
        Litespeedcache::setEnabled(config('litespeedcache.defaults.enabled'))
                      ->setEsiEnabled(config('litespeedcache.defaults.esiEnabled'))
                      ->setType(config('litespeedcache.defaults.type'))
                      ->setLifetime(config('litespeedcache.defaults.lifetime'))
                      ->setExcludedUrls(config('litespeedcache.defaults.excludedUris'))
                      ->setExcludedQueryStrings(config('litespeedcache.defaults.excludedQueryStrings'))
                      ->cache();

        return $next($request);
    }

}
