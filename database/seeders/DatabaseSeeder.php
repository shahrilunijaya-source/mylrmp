<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            InspectionPermissionsSeeder::class,
            AdminUserSeeder::class,
            ReferenceDataSeeder::class,
            DemoUsersSeeder::class,
            DemoApplicationsSeeder::class,
            InspectionChecklistSeeder::class,
            DemoPremisesSeeder::class,
            DemoInspectionsSeeder::class,
        ]);
    }
}
