<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MedicoController extends Controller
{
    private function asegurarAdministrador()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'administrador') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    public function index()
    {
        $this->asegurarAdministrador();

        $medicos = Medico::with('user')
            ->latest()
            ->paginate(8);

        return view('admin.medicos.index', compact('medicos'));
    }

    public function create()
    {
        $this->asegurarAdministrador();

        return view('admin.medicos.create');
    }

    public function store(Request $request)
    {
        $this->asegurarAdministrador();

        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'dni' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'required|string|max:100',
            'cmp' => 'nullable|string|max:50',
            'estado' => 'required|in:activo,inactivo',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nombres . ' ' . $request->apellidos,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tipo_usuario' => 'medico',
            ]);

            Medico::create([
                'user_id' => $user->id,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
                'telefono' => $request->telefono,
                'especialidad' => $request->especialidad,
                'cmp' => $request->cmp,
                'estado' => $request->estado,
            ]);
        });

        return redirect()
            ->route('admin.medicos.index')
            ->with('success', 'Médico registrado correctamente.');
    }

    public function edit(Medico $medico)
    {
        $this->asegurarAdministrador();

        $medico->load('user');

        return view('admin.medicos.edit', compact('medico'));
    }

    public function update(Request $request, Medico $medico)
    {
        $this->asegurarAdministrador();

        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($medico->user_id),
            ],
            'password' => 'nullable|min:6',
            'dni' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'required|string|max:100',
            'cmp' => 'nullable|string|max:50',
            'estado' => 'required|in:activo,inactivo',
        ]);

        DB::transaction(function () use ($request, $medico) {
            $user = $medico->user;

            $user->update([
                'name' => $request->nombres . ' ' . $request->apellidos,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $medico->update([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
                'telefono' => $request->telefono,
                'especialidad' => $request->especialidad,
                'cmp' => $request->cmp,
                'estado' => $request->estado,
            ]);
        });

        return redirect()
            ->route('admin.medicos.index')
            ->with('success', 'Médico actualizado correctamente.');
    }

    public function destroy(Medico $medico)
    {
        $this->asegurarAdministrador();

        DB::transaction(function () use ($medico) {
            $user = $medico->user;

            $medico->delete();

            if ($user) {
                $user->delete();
            }
        });

        return redirect()
            ->route('admin.medicos.index')
            ->with('success', 'Médico eliminado correctamente.');
    }
}