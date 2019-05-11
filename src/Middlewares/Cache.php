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
        // New Joostvanveen\Litespeedcache\Cache, including default values from config - set in Facade
        Litespeedcache::cache();

        return $next($request);
    }

}
