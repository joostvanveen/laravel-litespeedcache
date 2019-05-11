<?php

namespace Joostvanveen\LaravelLitespeedcache\Tests;

use LitespeedCache;

class HelpersTest extends TestCase
{

    /** @test */
    public function it_returns_esi_for_csrf_field_if_esi_enabled()
    {
        LitespeedCache::setUnitTestMode()->setEsiEnabled(true);
        $this->assertStringContainsString('<esi:include src="', getLitespeedCsrfField());
    }

    /** @test */
    public function it_returns_csrf_field_if_esi_disabled()
    {
        LitespeedCache::setUnitTestMode()->setEsiEnabled(false);
        $this->assertStringContainsString('<input type="hidden"', getLitespeedCsrfField());
    }

    /** @test */
    public function it_returns_csrf_field_if_cache_disabled()
    {
        LitespeedCache::setUnitTestMode()->setEnabled(false)->setEsiEnabled(true);
        $this->assertStringContainsString('<input type="hidden"', getLitespeedCsrfField());

        LitespeedCache::setUnitTestMode()->setLifetime(0)->setEsiEnabled(true);
        $this->assertStringContainsString('<input type="hidden"', getLitespeedCsrfField());
    }

    /** @test */
    public function it_returns_esi_for_csrf_token_if_esi_enabled()
    {
        LitespeedCache::setUnitTestMode()->setEsiEnabled(true);
        $this->assertStringContainsString('<esi:include src="', getLitespeedCsrfToken());
    }

    /** @test */
    public function it_returns_csrf_token_if_esi_disabled()
    {
        // We need to set session or token is empty
        $response = $this->withSession(['foo' => 'bar'])->get(config('litespeedcache.routes.token'));
        LitespeedCache::setUnitTestMode()->setEsiEnabled(false);
        $tokenString = getLitespeedCsrfToken();

        $this->assertNotEmpty($tokenString);
        $this->assertEquals(40, strlen($tokenString));
        $this->assertStringNotContainsString('<esi:include src="', $tokenString);
    }

    /** @test */
    public function it_returns_csrf_token_if_cache_disabled()
    {
        // We need to set session or token is empty
        $response = $this->withSession(['foo' => 'bar'])->get(config('litespeedcache.routes.token'));

        LitespeedCache::setUnitTestMode()->setEnabled(false)->setEsiEnabled(true);
        $tokenString = getLitespeedCsrfToken();
        $this->assertNotEmpty($tokenString);
        $this->assertEquals(40, strlen($tokenString));
        $this->assertStringNotContainsString('<esi:include src="', $tokenString);

        LitespeedCache::setUnitTestMode()->setLifetime(0)->setEsiEnabled(true);
        $tokenString = getLitespeedCsrfToken();
        $this->assertNotEmpty($tokenString);
        $this->assertEquals(40, strlen($tokenString));
        $this->assertStringNotContainsString('<esi:include src="', $tokenString);
    }
}
