<?php

namespace Joostvanveen\LaravelLitespeedcache\Tests;

class IntegrationTest extends TestCase
{

    /** @test */
    public function the_csrf_token_route_returns_a_200_response()
    {
        $this->get(config('litespeedcache.routes.token'))
             ->assertStatus(200);
    }

    /** @test */
    public function the_csrf_token_route_returns_a_csrf_token()
    {
        $response = $this->withSession(['foo' => 'bar'])->get(config('litespeedcache.routes.token'));
        $this->assertEquals(40,strlen($response->getContent()));
    }

    /** @test */
    public function the_csrf_field_route_returns_a_200_response()
    {
        $this->get(config('litespeedcache.routes.field'))
             ->assertStatus(200);
    }

    /** @test */
    public function the_csrf_field_route_returns_a_csrf_field_with_a_token()
    {
        $response = $this->withSession(['foo' => 'bar'])->get(config('litespeedcache.routes.field'));
        preg_match('/<input type="hidden" name="_token" value="[a-zA-Z0-9]{40}"/i', $response->getContent(), $matches);
        $this->assertNotEmpty($matches);
    }

}
