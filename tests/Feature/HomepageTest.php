<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_home_page_response_with_login_or_not(): void
    {
        if(Auth::check()){
            $response = $this->get('/');

            $response->assertStatus(200);
        } else {
            $response = $this->get('/');

            $response->assertStatus(302);
        }
    }
}
