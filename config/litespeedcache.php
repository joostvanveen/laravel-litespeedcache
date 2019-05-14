<?php

$csrfTokenUri = '/litespeedcache/csrf_token';
$csrfFieldUri = '/litespeedcache/csrf_field';

return [
    'defaults' => [
        'enabled' => true, // Litespeedcache headers are sent
        'esiEnabled' => true, // Enable ESI
        'enable_ajax_cache' => false, // Whether or not to cache ajax calls
        'use_middleware' => true, // Litespeed Cache Middleware is active
        'type' => 'public', // Default cache type
        'lifetime' => 240, // Default TTL for cache in minutes
        'excludedUris' => [ // URIs that should not be cached
            $csrfTokenUri . '*',
            $csrfFieldUri . '*',
        ],
        'excludedQueryStrings' => [], // Query strings that should not be cached
    ],
    'routes' => [
        'token' => $csrfTokenUri,
        'field' => $csrfFieldUri,
    ],
];
