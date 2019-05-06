<?php

Route::get(config('litespeedcache.routes.token'), '\Joostvanveen\LaravelLitespeedcache\Http\Controllers\LitespeedCacheController@csrfToken')
     ->name('litespeedcache.csrf.token');

Route::get(config('litespeedcache.routes.field'), '\Joostvanveen\LaravelLitespeedcache\Http\Controllers\LitespeedCacheController@csrfField')
    ->name('litespeedcache.csrf.field');
