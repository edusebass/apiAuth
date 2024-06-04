<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function assignRole($id, Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Encontrar el usuario
        $user = User::findOrFail($id);

        // Obtener el nombre del rol de la solicitud
        $roleName = $request->role;

        // Asignar el rol al usuario
        $user->assignRole($roleName);

        // Obtener el rol asignado
        $role = Role::findByName($roleName);

        // Sincronizar los permisos del rol al usuario
        $user->syncPermissions($role->permissions);

        // Obtener los permisos del usuario después de la asignación
        $permissions = $user->permissions()->pluck('name');

        // Devolver una respuesta JSON
        return response()->json([
            'message' => 'Role and permissions assigned successfully!',
            'user' => $user,
            'role' => $roleName,
            'permissions' => $permissions
        ]);
    }
}
