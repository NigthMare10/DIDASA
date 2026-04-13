<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_registration_fails_with_invalid_data(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'A',
            'email' => 'correo-invalido',
            'password' => '123',
            'password_confirmation' => '456',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest();
    }

    public function test_registration_is_rate_limited(): void
    {
        foreach (range(1, 5) as $intento) {
            $this->post('/register', [
                'name' => 'Usuario Demo',
                'email' => 'correo-invalido',
                'password' => 'corto',
                'password_confirmation' => 'distinto',
            ]);
        }

        $response = $this->post('/register', [
            'name' => 'Usuario Demo',
            'email' => 'correo-invalido',
            'password' => 'corto',
            'password_confirmation' => 'distinto',
        ]);

        $response->assertStatus(429);
    }
}
