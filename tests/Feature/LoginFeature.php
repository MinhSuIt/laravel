<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginFeature extends TestCase
{

    public function login_view()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login')->assertSee('Sign in');
    }
    public function loginInputProvider()
    {
        return [
            ['', ''],
            ['ajjjjj@gmail.com', ''],
            ['', 'ajjjjj@gmail.com'],
        ];
    }
    /** 
     * @test 
     * @dataProvider loginInputProvider
     */

    public function login_fail($email, $pass)
    {
        $response = $this->post('/login', [
            'email' => $email,
            'password' => $pass
        ]);

        if (empty($email) && empty($pass)) {
            $response->assertSessionHasErrors('email');
            $response->assertSessionHasErrors('password');
        } elseif (empty($email) && !empty($pass)) {
            $response->assertSessionHasErrors('email');
        } elseif (empty($pass) && !empty($email)) {
            $response->assertSessionHasErrors('password');
        }
        $response->assertStatus(302)
        // ->assertRedirect('login')
        ;
    }
    /**
     * @test
     */
    public function login_success()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $user->pass
        ]);
        $response->assertStatus(302)
        // ->assertRedirect(route('home'))
        ;
    }
}
