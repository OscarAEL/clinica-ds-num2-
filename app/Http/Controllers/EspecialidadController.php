<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function index()
    {
        // Traemos las especialidades reales de la base de datos usando Eloquent
        $especialidades = Especialidad::latest()->get();

        return view('admin.especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        return view('admin.especialidades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        // Guardamos directamente en la tabla SQLite
        Especialidad::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion ?? 'Sin descripción',
            'estado' => $request->estado,
        ]);

        return redirect()
            ->route('admin.especialidades.index')
            ->with('success', 'Especialidad registrada correctamente en la base de datos.');
    }

    public function edit(Especialidad $especialidad)
    {
        // Route Model Binding: Laravel inyecta automáticamente el objeto correspondiente al ID
        return view('admin.especialidades.edit', compact('especialidad'));
    }

    public function update(Request $request, Especialidad $especialidad)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        // Actualizamos los datos en la tabla SQLite
        $especialidad->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion ?? 'Sin descripción',
            'estado' => $request->estado,
        ]);

        return redirect()
            ->route('admin.especialidades.index')
            ->with('success', 'Especialidad actualizada correctamente.');
    }

    public function destroy(Especialidad $especialidad)
    {
        //
    }
}
