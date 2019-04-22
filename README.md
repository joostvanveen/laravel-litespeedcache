# joostvanveen/laravel-litespeedcache

A Laravel wrapper for joostvanveen/litespeedcache. If you wish to use Litespeed Cache outside of Laravel check out [https://github.com/joostvanveen/litespeedcache](https://github.com/joostvanveen/litespeedcache) 

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

TODO

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
