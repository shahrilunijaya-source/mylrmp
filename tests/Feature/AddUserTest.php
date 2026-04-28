<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddUserTest extends TestCase
{
    use DatabaseTransactions;

    private function superAdmin(): User
    {
        return User::role('Super Admin')->firstOrFail();
    }

    public function test_super_admin_can_see_tambah_pengguna_button(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->get(route('officer.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Pengguna');
    }

    public function test_super_admin_can_create_user(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->post(route('officer.users.store'), [
                'name'     => 'Ujian Pengguna',
                'email'    => 'ujian.baru@doa.gov.my',
                'password' => 'password123',
                'role'     => 'Pendaftar',
            ]);

        $response->assertRedirect(route('officer.users.index'));
        $response->assertSessionHas('success', 'Pengguna berjaya ditambah');
        $this->assertDatabaseHas('users', ['email' => 'ujian.baru@doa.gov.my']);
    }

    public function test_duplicate_email_fails_validation(): void
    {
        $existing = User::first();

        $response = $this->actingAs($this->superAdmin())
            ->post(route('officer.users.store'), [
                'name'     => 'Duplikat',
                'email'    => $existing->email,
                'password' => 'password123',
                'role'     => 'Pendaftar',
            ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_short_password_fails_validation(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->post(route('officer.users.store'), [
                'name'     => 'Pengguna Baharu',
                'email'    => 'baharu@doa.gov.my',
                'password' => 'short',
                'role'     => 'Pendaftar',
            ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_invalid_role_fails_validation(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->post(route('officer.users.store'), [
                'name'     => 'Pengguna Baharu',
                'email'    => 'baharu2@doa.gov.my',
                'password' => 'password123',
                'role'     => 'RoleYangTidakWujud',
            ]);

        $response->assertSessionHasErrors('role');
    }
}
