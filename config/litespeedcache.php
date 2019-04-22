<?php

return [
    'defaults' => [
        'enabled' => true, // Litespeedcache headers are sent
        'use_middleware' => true, // Litespeed Cache Middleware is active
        'type' => 'public', // Default cache type
        'lifetime' => 240, // Default TTL for cache in minutes
        'excludedUris' => [], // URIs that should not be cached
        'excludedQueryStrings' => [], // Query strings that should not be cached
    ],
];
