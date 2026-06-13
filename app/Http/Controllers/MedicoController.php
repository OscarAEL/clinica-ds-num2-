<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\User;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MedicoController extends Controller
{
    public function index()
    {
        // Cargamos al médico con su usuario Y también con su especialidad asociada
        $medicos = Medico::with(['user', 'especialidad'])
            ->latest()
            ->paginate(8);

        return view('admin.medicos.index', compact('medicos'));
    }

    public function create()
    {
        // Jalamos solo las especialidades activas para mostrarlas en el formulario
        $especialidades = Especialidad::where('estado', 'activo')->get();

        return view('admin.medicos.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'dni' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'especialidad_id' => 'required|exists:especialidades,id',
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
                'especialidad_id' => $request->especialidad_id,
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
        $medico->load('user');

        // Jalamos todas las especialidades activas para el formulario de edición
        $especialidades = Especialidad::where('estado', 'activo')->get();

        return view('admin.medicos.edit', compact('medico', 'especialidades'));
    }

    public function update(Request $request, Medico $medico)
    {
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
            'especialidad_id' => 'required|exists:especialidades,id',
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
                'especialidad_id' => $request->especialidad_id,
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
        // 
    }
}
