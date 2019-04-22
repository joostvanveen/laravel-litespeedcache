<?php
namespace Joostvanveen\LaravelLitespeedcache\Facades;

use Illuminate\Support\Facades\Facade;

class LitespeedCache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'litespeedcache';
    }
}
