<?php

/**
 * Return an ESI block if ESI is enabled, csrf_field() if ESI is disabled.
 *
 * @return \Illuminate\Support\HtmlString|string
 */
function getLitespeedCsrfField()
{
    if (LitespeedCache::getEnabled() == false) {
        return csrf_field();
    }

    return '<esi:include src="' . route('litespeedcache.csrf.field') . '" />';
}

/**
 * Return an ESI block if ESI is enabled, csrf_token() if ESI is disabled.
 *
 * @return string
 */
function getLitespeedCsrfToken()
{
    if (LitespeedCache::getEnabled() == false) {
        return csrf_token();
    }

    return '<esi:include src="' . route('litespeedcache.csrf.token') . '" />';
}
