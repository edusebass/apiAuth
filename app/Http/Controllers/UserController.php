<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Mostrar una lista de usuarios
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Mostrar el formulario para crear un nuevo usuario (sólo para web)
    public function create()
    {
        // Retorna una vista para crear un usuario
    }

    // Almacenar un nuevo usuario
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $user = User::create([
            'username' => $validatedData['username'],
            'password' => bcrypt($validatedData['password']),
            'email' => $validatedData['email'],
        ]);

        return response()->json($user, 201);
    }

    // Mostrar un usuario específico
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Mostrar el formulario para editar un usuario (sólo para web)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        // Retorna una vista para editar el usuario
        return response()->json($user);
    }

    // Actualizar un usuario específico
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|required|string|min:8',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'person_id' => 'sometimes|required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->update($validatedData);

        return response()->json($user);
    }

    // Eliminar un usuario específico
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
