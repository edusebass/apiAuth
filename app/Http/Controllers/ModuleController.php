<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class ModuleController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
        ]);

        // Buscar el rol por su nombre
        $roleName = $request->input('role');
        $role = ModelsRole::where('name', $roleName)->first();

        if (!$role) {
            return response()->json(['error' => 'Rol no encontrado'], 404);
        }

        // Crear el módulo y asignar el ID del rol
        $module = new Module();
        $module->name = $request->input('name');
        $module->role_id = $role->id;
        $module->save();

        return response()->json([
            'message' => 'Módulo creado exitosamente',
            'module' => $module,
        ], 201);
    }
}
