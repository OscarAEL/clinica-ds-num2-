<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicoPanelController extends Controller
{
    private function obtenerMedico()
    {
        // El administrador ya creó al médico en la BD, así que solo lo buscamos
        return Medico::where('user_id', Auth::id())->firstOrFail();
    }

    public function home()
    {
        return view('medico.home');
    }

    public function perfil()
    {
        $medico = $this->obtenerMedico();
        return view('medico.perfil', compact('medico'));
    }

    public function actualizarPerfil(Request $request)
    {
        $medico = $this->obtenerMedico();

        // Ya no validamos la especialidad porque el médico no puede cambiársela él mismo
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'dni' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'cmp' => 'nullable|string|max:50',
        ]);

        $medico->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'cmp' => $request->cmp,
        ]);

        $medico->user->update([
            'name' => trim($request->nombres . ' ' . $request->apellidos),
        ]);

        return redirect()
            ->route('medico.perfil')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function citas()
    {
        $medico = $this->obtenerMedico();

        // Jalamos SOLO los horarios que ya fueron reservados por pacientes
        $citas = Horario::where('medico_id', $medico->id)
            ->where('estado', 'no_disponible')
            ->latest()
            ->get();

        return view('medico.citas.index', compact('citas'));
    }
}
