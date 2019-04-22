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

### Facade

The package registers `\Joostvanveen\Litespeedcache\Cache` as a facade and sets default config values for `enabled`, `type` and `lifetime`.

```php
use LitespeedCache;

[...]

// Cache use all default settings from config.
LitespeedCache::cache();
``` 

You can use all methods from `\Joostvanveen\Litespeedcache\Cache`, see [https://github.com/joostvanveen/litespeedcache/blob/master/README.md](https://github.com/joostvanveen/litespeedcache/blob/master/README.md) for full documentation.
```php
// Example
$excludedUris = [
    'checkout*',
    'admin*',
];
LitespeedCache::setType('private')->setLifetime(120)->setExcludedUrls($excludedUris)->cache();
```

### Config
Default values are set in a config file.
 
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
```

### Middleware
By default, the package contains a middleware that caches all pages (except cli, ajax andd http verbs other than GET and HEAD).

You can find this middleware at `src/Middlewares/Cache.php`.

If you want to use your own middleware, you can disable the default middleware by setting the config value `litespeedcache.defaults.use_middleware` to `false`

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
