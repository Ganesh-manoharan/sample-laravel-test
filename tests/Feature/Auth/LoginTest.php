<?php

namespace Tests\Feature\Auth;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class LoginTest extends TestCase
{
     /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_authentication_failure()
    {
        $response = $this->post('/login', [
            'email' => 'alvaro.aitech@gmail.com',
            'password' => '1234567',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertLocation('/');
        
    }

    public function test_admin_authentication_success()
    {
        $response = $this->post('/login', [
            'email' => 'alvaro.aitech@gmail.com',
            'password' => '12345678',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertLocation('/admin/home');
    }

    public function test_manager_authentication_success()
    {
        $response = $this->post('/login', [
            'email' => 'heath.aitech@gmail.com',
            'password' => '12345678',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertLocation('/manager/home');
    }

    public function test_user_authentication_success()
    {
        $response = $this->post('/login', [
            'email' => 'peter.aitech@gmail.com',
            'password' => '12345678',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertLocation('/user/home');
    }

}
