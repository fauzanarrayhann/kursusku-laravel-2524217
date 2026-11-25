<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private function validData(array $override = []): array
    {
        return array_merge([
            'name'                  => 'Budi Santoso',
            'username'              => 'budi_01',
            'email'                 => 'budi@example.test',
            'password'              => 'Budi#12345',
            'password_confirmation' => 'Budi#12345',
        ], $override);
    }

    public function test_register_page_can_be_opened(): void
    {
        $this->get('/register')->assertOk();
    }

    public function test_user_can_register_and_is_logged_in_with_user_role(): void
    {
        $this->post('/register', $this->validData())
            ->assertRedirect(route('profile.index'));

        $user = User::where('username', 'budi_01')->first();

        $this->assertNotNull($user);
        $this->assertSame('user', $user->role);
        $this->assertTrue($user->is_active);
        $this->assertNotSame('Budi#12345', $user->password); // tersimpan sebagai hash
        $this->assertAuthenticatedAs($user);
    }

    public function test_role_cannot_be_set_from_the_form(): void
    {
        $this->post('/register', $this->validData(['role' => 'admin', 'is_active' => false]));

        $user = User::where('username', 'budi_01')->first();

        $this->assertSame('user', $user->role);
        $this->assertTrue($user->is_active);
    }

    public function test_username_and_email_are_stored_in_lowercase(): void
    {
        $this->post('/register', $this->validData([
            'username' => 'Budi_01',
            'email'    => 'Budi@Example.Test',
        ]));

        $this->assertDatabaseHas('users', [
            'username' => 'budi_01',
            'email'    => 'budi@example.test',
        ]);
    }

    public function test_duplicate_username_and_email_are_rejected(): void
    {
        $this->post('/register', $this->validData());
        auth()->logout();

        $this->post('/register', $this->validData(['email' => 'lain@example.test']))
            ->assertSessionHasErrors('username');

        $this->post('/register', $this->validData(['username' => 'budi_02']))
            ->assertSessionHasErrors('email');

        $this->assertSame(1, User::count());
    }

    public function test_weak_or_unconfirmed_password_is_rejected(): void
    {
        $this->post('/register', $this->validData([
            'password' => 'abc123', 'password_confirmation' => 'abc123',
        ]))->assertSessionHasErrors('password');

        $this->post('/register', $this->validData(['password_confirmation' => 'Beda#12345']))
            ->assertSessionHasErrors('password');

        $this->assertSame(0, User::count());
    }

    public function test_invalid_username_characters_are_rejected(): void
    {
        $this->post('/register', $this->validData(['username' => 'budi santoso!']))
            ->assertSessionHasErrors('username');
    }

    public function test_registered_user_can_login_again(): void
    {
        $this->post('/register', $this->validData());
        auth()->logout();

        $this->post('/login', ['login' => 'budi_01', 'password' => 'Budi#12345']);

        $this->assertAuthenticated();
    }

    public function test_logged_in_user_cannot_open_register_page(): void
    {
        $this->post('/register', $this->validData());

        $this->get('/register')->assertRedirect();
    }
}
