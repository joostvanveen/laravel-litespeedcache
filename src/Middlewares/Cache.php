<?php

namespace Joostvanveen\LaravelLitespeedcache\Middlewares;

use Closure;
use Joostvanveen\Litespeedcache\Cache as Litespeedcache;

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
        if (config('litespeedcache.defaults.use_middleware') == false) {
            return $next($request);
        }

        (new Litespeedcache)->setEnabled(config('litespeedcache.defaults.enabled'))
                            ->setType(config('litespeedcache.defaults.type'))
                            ->setLifetime(config('litespeedcache.defaults.lifetime'))
                            ->cache();

        return $next($request);
    }

}
