<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicoPanelController extends Controller
{
    private function validarMedico()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'medico') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    private function medicoActual()
    {
        $this->validarMedico();

        $user = Auth::user();

        return Medico::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nombres' => $user->name ?? 'Médico',
                'apellidos' => '',
                'dni' => null,
                'telefono' => null,
                'especialidad' => 'No asignada',
                'cmp' => null,
                'estado' => 'activo',
            ]
        );
    }

    public function home()
    {
        $this->validarMedico();

        return view('medico.home');
    }

    public function perfil()
    {
        $medico = $this->medicoActual();

        return view('medico.perfil', compact('medico'));
    }

    public function actualizarPerfil(Request $request)
    {
        $medico = $this->medicoActual();

        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'dni' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'required|string|max:100',
            'cmp' => 'nullable|string|max:50',
        ]);

        $medico->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
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
        $medico = $this->medicoActual();

        return view('medico.citas.index', compact('medico'));
    }
}