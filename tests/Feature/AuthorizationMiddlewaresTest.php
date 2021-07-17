<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Request;
use App\Http\Middleware\AdminMiddleware;

class AuthorizationMiddlewaresTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_non_admins_are_redirected()
    {
        $response  = $this->post('/login', [
            'email' => 'peter.aitech@gmail.com',
            'password' => '12345678',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertLocation('/user/home');
    }
}
