<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(array $override = []): User
    {
        return User::create(array_merge([
            'name'      => 'Admin Test',
            'username'  => 'admin',
            'email'     => 'admin@kursusku.test',
            'password'  => 'Admin#1234',
            'role'      => 'admin',
            'is_active' => true,
        ], $override));
    }

    public function test_login_page_can_be_opened(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_user_can_login_with_username_and_last_login_is_saved(): void
    {
        $user = $this->makeUser();

        $this->post('/login', ['login' => 'admin', 'password' => 'Admin#1234'])
            ->assertRedirect(route('profile.index'));

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->last_login_at);
    }

    public function test_user_can_login_with_email(): void
    {
        $user = $this->makeUser();

        $this->post('/login', ['login' => 'admin@kursusku.test', 'password' => 'Admin#1234']);

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_password_and_inactive_account_are_rejected(): void
    {
        $this->makeUser();

        $this->post('/login', ['login' => 'admin', 'password' => 'salah'])
            ->assertSessionHasErrors('login');
        $this->assertGuest();

        User::where('username', 'admin')->update(['is_active' => false]);

        $this->post('/login', ['login' => 'admin', 'password' => 'Admin#1234'])
            ->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_for_protected_pages(): void
    {
        $this->get('/admin/profile')->assertRedirect(route('login'));
        $this->get('/courses')->assertRedirect(route('login'));
    }

    public function test_profile_page_shows_for_logged_in_user(): void
    {
        $this->actingAs($this->makeUser())
            ->get('/admin/profile')
            ->assertOk()
            ->assertSee('Profil Saya');
    }

    public function test_profile_can_be_updated(): void
    {
        $user = $this->makeUser();

        $this->actingAs($user)->put('/admin/profile', [
            'name'  => 'Nama Baru',
            'email' => 'baru@kursusku.test',
            'phone' => '081234567890',
        ])->assertSessionHasNoErrors();

        $this->assertSame('Nama Baru', $user->fresh()->name);
        $this->assertSame('baru@kursusku.test', $user->fresh()->email);
    }

    public function test_logout_works(): void
    {
        $this->actingAs($this->makeUser())
            ->post('/logout')
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_weak_new_password_is_rejected(): void
    {
        $this->actingAs($this->makeUser())
            ->put('/admin/profile/password', [
                'current_password'      => 'Admin#1234',
                'password'              => 'abc123',
                'password_confirmation' => 'abc123',
            ])->assertSessionHasErrors('password');
    }

    public function test_strong_new_password_can_be_saved(): void
    {
        $this->actingAs($this->makeUser())
            ->put('/admin/profile/password', [
                'current_password'      => 'Admin#1234',
                'password'              => 'Baru#98765',
                'password_confirmation' => 'Baru#98765',
            ])->assertSessionHasNoErrors();

        auth()->logout();
        $this->post('/login', ['login' => 'admin', 'password' => 'Baru#98765']);
        $this->assertAuthenticated();
    }

    public function test_forgot_password_resets_when_username_and_email_match(): void
    {
        $this->makeUser();

        $this->post('/forgot-password', [
            'username'              => 'admin',
            'email'                 => 'admin@kursusku.test',
            'password'              => 'Reset#98765',
            'password_confirmation' => 'Reset#98765',
        ])->assertRedirect(route('login'));

        $this->post('/login', ['login' => 'admin', 'password' => 'Reset#98765']);
        $this->assertAuthenticated();
    }

    public function test_forgot_password_rejects_mismatched_username_and_email(): void
    {
        $this->makeUser();

        $this->post('/forgot-password', [
            'username'              => 'admin',
            'email'                 => 'orang-lain@kursusku.test',
            'password'              => 'Reset#98765',
            'password_confirmation' => 'Reset#98765',
        ])->assertSessionHasErrors('email');
    }
}
