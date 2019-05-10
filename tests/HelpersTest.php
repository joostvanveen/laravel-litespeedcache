<?php

namespace Joostvanveen\LaravelLitespeedcache\Tests;

use LitespeedCache;

class HelpersTest extends TestCase
{

    /** @test */
    public function it_returns_esi_for_csrf_field_if_esi_enabled()
    {
        $this->assertStringContainsString('<esi:include src="', getLitespeedCsrfField());
    }

    /** @test */
    public function it_returns_csrf_field_if_esi_disabled()
    {
        LitespeedCache::setEnabled(false);
        $this->assertStringContainsString('<input type="hidden"', getLitespeedCsrfField());
    }

    /** @test */
    public function it_returns_esi_for_csrf_token_if_esi_enabled()
    {
        $this->assertStringContainsString('<esi:include src="', getLitespeedCsrfToken());
    }

    /** @test */
    public function it_returns_csrf_token_if_esi_disabled()
    {
        // We need to set session or token is empty
        $response = $this->withSession(['foo' => 'bar'])->get(config('litespeedcache.routes.token'));
        LitespeedCache::setEnabled(false);
        $tokenString = getLitespeedCsrfToken();

        $this->assertNotEmpty($tokenString);
        $this->assertEquals(40, strlen($tokenString));
        $this->assertStringNotContainsString('<esi:include src="', $tokenString);
    }
}
