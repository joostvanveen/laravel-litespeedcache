<?php

namespace Joostvanveen\LaravelLitespeedcache\Http\Controllers;

use Illuminate\Routing\Controller;

/**
 * Class LitespeedCacheController
 *
 * @package Joostvanveen\LaravelLitespeedcache\Http\Controllers
 */
class LitespeedCacheController extends Controller
{

    /**
     * @return string - Laravel CSRF token only.
     */
    public function csrfToken()
    {
        return csrf_token();
    }

    /**
     * @return \Illuminate\Support\HtmlString - Laravel CSRF hidden field.
     */
    public function csrfField()
    {
        return csrf_field();
    }
}
