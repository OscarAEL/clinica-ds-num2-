<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    private function validarAdministrador()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'administrador') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    public function index()
    {
        $this->validarAdministrador();

        $usuarios = User::orderBy('tipo_usuario')
            ->orderBy('name')
            ->get();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function edit(User $usuario)
    {
        $this->validarAdministrador();

        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validamos ÚNICAMENTE el campo que sí estamos enviando (el select del perfil)
        $request->validate([
            'tipo_usuario' => 'required|in:paciente,medico,administrador',
        ]);

        // 2. Buscamos el usuario en la base de datos
        $usuario = \App\Models\User::findOrFail($id);

        // 3. Actualizamos solo el rol/perfil, respetando el nombre y correo intactos
        $usuario->update([
            'tipo_usuario' => $request->tipo_usuario,
        ]);

        // 4. Redirigimos con mensaje de éxito
        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'El perfil del usuario ha sido actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        //
    }
}
