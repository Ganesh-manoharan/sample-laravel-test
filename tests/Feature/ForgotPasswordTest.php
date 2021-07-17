<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_forgot_password_mail_not_available()
    {
        $response = $this->post('/password/email', [
            'email' => 'heath.aitech@gmail.com',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertSee('Invalid');
    }

    public function test_forgot_password_mail_sent()
    {
        $response = $this->post('/password/email', [
            'email' => 'alvaro.aitech@gmail.com',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertSee('sent');
    }
}
