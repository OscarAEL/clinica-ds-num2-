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

    public function update(Request $request, User $usuario)
    {
        $this->validarAdministrador();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
            'password' => 'nullable|min:6',
            'tipo_usuario' => 'required|in:administrador,medico,paciente',
        ]);

        $datos = [
            'name' => $request->name,
            'email' => $request->email,
            'tipo_usuario' => $request->tipo_usuario,
        ];

        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        $usuario->update($datos);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $this->validarAdministrador();

        if ($usuario->id === Auth::id()) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        $usuario->delete();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}