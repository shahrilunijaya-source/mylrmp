<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class KawalanAksesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    private function superAdmin(): User
    {
        return User::role('Super Admin')->firstOrFail();
    }

    public function test_kawalan_akses_page_redirects_to_first_role(): void
    {
        $firstRole = Role::orderBy('id')->first();

        $response = $this->actingAs($this->superAdmin())
            ->get(route('officer.access.index'));

        $response->assertRedirect(route('officer.access.index') . '?role=' . $firstRole->id);
    }

    public function test_kawalan_akses_shows_permissions_for_selected_role(): void
    {
        $role = Role::where('name', 'Pendaftar')->firstOrFail();

        $response = $this->actingAs($this->superAdmin())
            ->get(route('officer.access.index') . '?role=' . $role->id);

        $response->assertStatus(200);
        $response->assertSee('applications.view_any');
    }

    public function test_super_admin_can_update_role_permissions(): void
    {
        $role = Role::where('name', 'Penilai Label')->firstOrFail();

        $response = $this->actingAs($this->superAdmin())
            ->put(route('officer.access.update', $role), [
                'permissions' => ['applications.view_any', 'audit.view'],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->assertTrue($role->fresh()->hasPermissionTo('applications.view_any'));
        $this->assertTrue($role->fresh()->hasPermissionTo('audit.view'));
        $this->assertFalse($role->fresh()->hasPermissionTo('applications.review_label'));
    }

    public function test_invalid_permission_fails_validation(): void
    {
        $role = Role::where('name', 'Pendaftar')->firstOrFail();

        $response = $this->actingAs($this->superAdmin())
            ->put(route('officer.access.update', $role), [
                'permissions' => ['permission.yang.tidak.wujud'],
            ]);

        $response->assertSessionHasErrors();
    }
}
