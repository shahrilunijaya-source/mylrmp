<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions grouped by resource
        $permissions = [
            // Applications
            'applications.view_any',
            'applications.view_own',
            'applications.create',
            'applications.submit',
            'applications.review_intake',
            'applications.review_technical',
            'applications.review_label',
            'applications.approve_final',
            'applications.reject',
            'applications.withdraw',
            // Products
            'products.view_any',
            'products.view_published',
            'products.create',
            'products.update',
            'products.delete',
            // Companies
            'companies.view_any',
            'companies.view_own',
            'companies.create',
            'companies.update',
            'companies.delete',
            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            // Roles
            'roles.view',
            'roles.update_permissions',
            // Reference data
            'reference_data.manage_categories',
            'reference_data.manage_ingredients',
            'reference_data.manage_crops',
            'reference_data.manage_pests',
            'reference_data.manage_formulations',
            // Audit
            'audit.view',
            // Certificates
            'certificates.view',
            'certificates.regenerate',
            // Settings
            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions(Permission::all());

        $pendaftar = Role::firstOrCreate(['name' => 'Pendaftar']);
        $pendaftar->syncPermissions([
            'applications.view_any',
            'applications.approve_final',
            'applications.reject',
            'applications.review_intake',
            'products.view_any',
            'products.create',
            'products.update',
            'companies.view_any',
            'audit.view',
            'certificates.view',
            'certificates.regenerate',
        ]);

        $penilaiTeknikal = Role::firstOrCreate(['name' => 'Penilai Teknikal']);
        $penilaiTeknikal->syncPermissions([
            'applications.view_any',
            'applications.review_technical',
            'products.view_any',
            'audit.view',
            'certificates.view',
        ]);

        $penilaiLabel = Role::firstOrCreate(['name' => 'Penilai Label']);
        $penilaiLabel->syncPermissions([
            'applications.view_any',
            'applications.review_label',
            'products.view_any',
            'audit.view',
            'certificates.view',
        ]);

        $pegawaiPendaftaran = Role::firstOrCreate(['name' => 'Pegawai Pendaftaran']);
        $pegawaiPendaftaran->syncPermissions([
            'applications.view_any',
            'applications.review_intake',
            'products.view_any',
            'companies.view_any',
            'audit.view',
            'certificates.view',
        ]);

        $industri = Role::firstOrCreate(['name' => 'Industri']);
        $industri->syncPermissions([
            'applications.view_own',
            'applications.create',
            'applications.submit',
            'applications.withdraw',
            'products.view_published',
            'companies.view_own',
            'companies.update',
            'certificates.view',
        ]);
    }
}
