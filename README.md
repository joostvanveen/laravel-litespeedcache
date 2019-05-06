# joostvanveen/laravel-litespeedcache

A Laravel wrapper for joostvanveen/litespeedcache. If you wish to use Litespeed Cache outside of Laravel check out this framework agnostic [https://github.com/joostvanveen/litespeedcache](https://github.com/joostvanveen/litespeedcache) 

## Installation
Require the package using composer:
```
composer require joostvanveen/laravel-litespeedcache
```

Enable the Litespeed in your .htaccess file.
```
<IfModule LiteSpeed>
    # Enable public cache
    CacheEnable public /
    
    # Enable private cache if you need to
    CacheEnable private /
    
    # Check the public cache
    CacheLookup public on
    
    # Ignore normal Cache Control headers
    CacheIgnoreCacheControl On
    
    # Maximum expiration time in seconds
    CacheMaxExpire 604800
</IfModule>
``` 

## Usage

This package adds a `LitespeedCache` cache facade for easy use and sets middleware that automatically caches all requests, according to the config settings.

You can set which URLs (for instance any `adminconsole*`) and query strings not to cache in config.
If you want to preview a page without cache, simply add `?cache_bypass=1` to a URL, or set a `cache_bypass` cookie with a vale of 1.

If you want to set your own middleware, you can set the package to **not** use the default middleware.
 
### Configuration
To be able to adjust the configuration for this package, publish the configuration files to your project's `/config` folder like so:
```php
php artisan vendor:publish --provider="Joostvanveen\LaravelLitespeedcache\LitespeedCacheServiceProvider" --tag=config
```

The config file adds the following settings to your Laravel configuration:
```php
config('litespeedcache.defaults.enabled') // true
config('litespeedcache.defaults.use_middleware') // true
config('litespeedcache.defaults.type') // 'public'
config('litespeedcache.defaults.lifetime') // 240 minutes
config('litespeedcache.defaults.excludedUris') // Array of URIs that should not be cached, can contain wildcards like '/admin*'
config('litespeedcache.defaults.excludedQueryStrings') // Array of query strings that should not be cached, can contain wildcards like '*utm_source=*'
```

### Facade

The package registers `\Joostvanveen\Litespeedcache\Cache` as a facade and sets default config values for 
`litespeedcache.defaults.enabled`,
`litespeedcache.defaults.type`,
`litespeedcache.defaults.lifetime`,
`litespeedcache.defaults.excludedUris`,
and `litespeedcache.defaults.excludedQueryStrings`.

```php
use LitespeedCache;

[...]

// Cache use all default settings from config.
LitespeedCache::cache();

// Purge the cache
LitespeedCache::purge();
``` 

You can use all methods from `\Joostvanveen\Litespeedcache\Cache`, see [https://github.com/joostvanveen/litespeedcache/blob/master/README.md](https://github.com/joostvanveen/litespeedcache/blob/master/README.md) for full documentation.

Some examples:
```php
// Full options example
// You can also set $excludedUris and $excludedQueryStrings in config.
$excludedUris = [
    'checkout*',
    'admin*',
];
$excludedQueryStrings = [
    '*direction=*',
];
LitespeedCache::setType('private')->setLifetime(120)
                                  ->addTags(['articles', 'en_GB'])
                                  ->addVary('value=mysubdomain')
                                  ->setExcludedUrls($excludedUris)
                                  ->setExcludedQueryStrings($excludedQueryStrings)
                                  ->cache();
                                  
// Purge cache using tags.
LitespeedCache::addTags('articles')->purge();

// If the lifetime is set to 0 the page will not be cached
(new Cache)->setEnabled(true)->setLifetime(0)->cache();
```

### Middleware
By default, the package contains a middleware that caches all pages (except cli, ajax andd http verbs other than GET and HEAD).

You can find this middleware at `src/Middlewares/Cache.php`.

If you want to use your own middleware, you can disable the default middleware by setting the config value `litespeedcache.defaults.use_middleware` to `false`

1. Publish the config settings to your Laravel project.
```php
php artisan vendor:publish --provider="Joostvanveen\LaravelLitespeedcache\LitespeedCacheServiceProvider" --tag=config
```

2. Set `use_middleware` to `false`
```php
<?php

return [
    'defaults' => [
        'enabled' => true, 
        'use_middleware' => false, // Set Litespeed Cache Middleware to inactive
        'type' => 'public', 
        'lifetime' => 240, 
    ],
];
```

3. Create a middleware class
```php
php artisan make:middleware LitespeedCache
``` 

4. Edit your middleware
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Joostvanveen\LaravelLitespeedcache\Facades\LitespeedCache as LitespeedCacheFacade;

class LitespeedCache
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
        $excludedUris = [
            'checkout*',
            'admin*',
        ];
        
        LitespeedCacheFacade::setEnabled(config('litespeedcache.defaults.enabled'))
                            ->setType(config('litespeedcache.defaults.type'))
                            ->setLifetime(config('litespeedcache.defaults.lifetime'))
                            ->setExcludedUrls($excludedUris)
                            ->cache();

        return $next($request);
    }
}
```

## Cache and csrf tokens in form requests
Laravel has built in security to guard against csrf attacks, using a csrf token. A token check is done on every POST request. 

Typically, you provide the csrf token as a hidden field in a form, using `csrf_field()` or in a POST ajax request, 
using something like `$.post(route('my.route'), $('#form').serialize() + "&_token={{ csrf_token() }});` 

This poses a problem when used with a full page cache like Litespeed Cache or Varnish. The csrf is unique and should 
not be stored in cache. If it is you will be posting a cached csrf token instead of a fresh one, resulting in a 'This page has expired' error on doing a POST request. However, you **do** 
want to store the rest of the page in cache. You need some way to do hole punching in your cached page. ESI to the rescue.

This package provides two ways to use csrf tokens in you pages as an ESI block. On constructing the cached page, the 
ESI block will be replaced by the actual, uncached csrf token. This way you can have a fully cached paged, but 
**with** a uncached token.

Use the following code to include a hidden field in your form instead of `csrf_field()`. The 'litespeedcache.routes.field' route
is part of this package an will return a hidden field with csrf token. Use the ESI block in your page like so: 
```php
<esi:include src="{{ route('litespeedcache.csrf.field') }}" />
``` 

This ESI block will be replaced with the following string (where xxxx is a csrf token):
```php
<input type="hidden" name="_token" value="xxxx">
```

Here's a complete example:
```php
<form action="/example-url" method="POST">
<esi:include src="{{ route('litespeedcache.csrf.field') }}" />
Your email: <input type="email" name="email" required><br>
<input type="submit">
</form>
```

Use the following code to include a csrf token in your page instead of `csrf_token()`. The 'litespeedcache.routes.token' route
is part of this package an will return just a csrf token. Use the ESI block in your page like so:
```php
<esi:include src="{{ route('litespeedcache.csrf.token') }}" />
``` 

This ESI block will be replaced with the following string (where xxxx is a csrf token):
```php
xxxx
```

Here's a complete example:
```php
$.post(
    '/example-url', 
    { 
        '_token' : '<esi:include src="{{ route('litespeedcache.csrf.token') }}" />', 
        'data' : $(this).serialize() 
    }, 
    function(data) {
        // Do something
    }
);
```

## joostvanveen/litespeedcache documentation

You can find the Litespeed Cache documentation here [https://github.com/joostvanveen/litespeedcache/blob/master/README.md](https://github.com/joostvanveen/litespeedcache/blob/master/README.md)

## Litespeed documentation

You can find the Litespeed Cache documentation here [https://www.litespeedtech.com/support/wiki/doku.php/litespeed_wiki:cache:developer_guide:response_headers](https://www.litespeedtech.com/support/wiki/doku.php/litespeed_wiki:cache:developer_guide:response_headers)

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## Changelog
[Changelog](/joostvanveen/litespeedcache/blob/master/CHANGELOG.md)

## License
[MIT](/joostvanveen/litespeedcache/blob/master/LICENSE.md)
