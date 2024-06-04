<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateRolesAndPermissionsTables extends Migration
{
    public function up()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
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

        // Crear roles y asignar permisos
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $teacherRole->syncPermissions(['edit articles', 'publish articles', 'view articles']);
    }

    public function down()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'edit articles',
            'delete articles',
            'publish articles',
            'unpublish articles',
            'view articles'
        ];

        // Eliminar roles y permisos
        Role::where('name', 'admin')->first()->revokePermissionTo($permissions);
        Role::where('name', 'teacher')->first()->revokePermissionTo(['edit articles', 'publish articles', 'view articles']);
        Role::where('name', 'admin')->delete();
        Role::where('name', 'teacher')->delete();

        Permission::whereIn('name', $permissions)->delete();
    }
}
