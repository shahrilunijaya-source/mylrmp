<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InspectionPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'premises.view',
            'premises.create',
            'premises.edit',
            'inspections.view',
            'inspections.schedule',
            'inspections.conduct',
            'inspections.cancel',
            'inspection_checklist_items.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::findByName('Super Admin');
        $superAdmin->givePermissionTo($permissions);

        $pegawaiPendaftaran = Role::findByName('Pegawai Pendaftaran');
        $pegawaiPendaftaran->givePermissionTo([
            'premises.view',
            'premises.create',
            'premises.edit',
            'inspections.view',
            'inspections.schedule',
            'inspections.cancel',
        ]);

        $pegawaiPemeriksaan = Role::firstOrCreate(['name' => 'Pegawai Pemeriksaan']);
        $pegawaiPemeriksaan->syncPermissions([
            'premises.view',
            'premises.create',
            'premises.edit',
            'inspections.view',
            'inspections.conduct',
        ]);
    }
}
