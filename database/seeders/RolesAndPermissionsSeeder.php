<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'edit articles',
            'delete articles',
            'publish articles',
            'unpublish articles',
            'view articles'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $teacherRole->syncPermissions(['edit articles', 'publish articles', 'view articles']);
    }
}
