<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::create([
            'name' => 'Admin', 'username' => 'admin', 'email' => 'admin@kursusku.test',
            'password' => 'Admin#1234', 'role' => 'admin', 'is_active' => true,
        ]);
    }

    private function makeUser(): User
    {
        return User::create([
            'name' => 'Budi', 'username' => 'budi', 'email' => 'budi@kursusku.test',
            'password' => 'Budi#12345', 'role' => 'user', 'is_active' => true,
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/courses')->assertRedirect(route('login'));
        $this->get('/enrollments')->assertRedirect(route('login'));
        $this->get('/enrollments/create')->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_open_admin_pages(): void
    {
        $this->actingAs($this->makeUser());

        $this->get('/courses')->assertForbidden();
        $this->get('/courses/create')->assertForbidden();
        $this->post('/courses', [])->assertForbidden();
        $this->get('/enrollments')->assertForbidden();
    }

    public function test_regular_user_can_use_profile_and_enrollment_form(): void
    {
        $this->actingAs($this->makeUser());

        $this->get('/admin/profile')->assertOk();
        $this->get('/enrollments/create')->assertOk();
        $this->get('/courses/1/availability')
            ->assertOk()
            ->assertJson(['course' => 'Web Dasar']);
    }

    public function test_admin_can_open_admin_pages(): void
    {
        $this->actingAs($this->makeAdmin());

        $this->get('/courses')->assertOk();
        $this->get('/courses/create')->assertOk();
        $this->get('/enrollments')->assertOk();
    }

    public function test_inactive_admin_is_treated_as_regular_user(): void
    {
        $admin = $this->makeAdmin();
        $admin->update(['is_active' => false]);

        $this->actingAs($admin)->get('/courses')->assertForbidden();
    }

    public function test_navbar_shows_admin_menu_only_for_admin(): void
    {
        $this->actingAs($this->makeUser())
            ->get('/admin/profile')
            ->assertDontSee(route('courses.index'));

        $this->actingAs($this->makeAdmin())
            ->get('/admin/profile')
            ->assertSee(route('courses.index'));
    }
}
