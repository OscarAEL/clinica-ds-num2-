<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioMedicoController extends Controller
{
    // Función de apoyo para obtener el perfil médico del usuario logueado
    private function obtenerMedicoAutenticado()
    {
        return Medico::where('user_id', Auth::id())->firstOrFail();
    }

    public function index()
    {
        // Si es administrador, ve absolutamente todos los horarios con los nombres de los médicos
        if (Auth::user()->tipo_usuario === 'administrador') {
            $horarios = Horario::with('medico')->latest()->get();
        } else {
            // Si es médico, ve solo los suyos
            $medico = $this->obtenerMedicoAutenticado();
            $horarios = Horario::where('medico_id', $medico->id)->get();
        }

        return view('medico.horarios.index', compact('horarios'));
    }

    public function create()
    {
        return view('medico.horarios.create');
    }

    public function store(Request $request)
    {
        $medico = $this->obtenerMedicoAutenticado();

        $request->validate([
            'dia_semana' => 'required|string|max:30',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'consultorio' => 'nullable|string|max:100',
            'estado' => 'required|in:disponible,no_disponible',
        ]);

        Horario::create([
            'medico_id' => $medico->id,
            'dia_semana' => $request->dia_semana,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'consultorio' => $request->consultorio ?? 'No asignado',
            'estado' => $request->estado,
        ]);

        return redirect()
            ->route('medico.horarios.index')
            ->with('success', 'Horario registrado en la base de datos correctamente.');
    }

    public function edit($id)
    {
        $medico = $this->obtenerMedicoAutenticado();

        // Buscamos el horario real asegurándonos de que sea de este médico
        $horario = Horario::where('medico_id', $medico->id)->findOrFail($id);

        return view('medico.horarios.edit', compact('horario'));
    }

    public function update(Request $request, $id)
    {
        $medico = $this->obtenerMedicoAutenticado();

        $request->validate([
            'dia_semana' => 'required|string|max:30',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
            'consultorio' => 'nullable|string|max:100',
            'estado' => 'required|in:disponible,no_disponible',
        ]);

        $horario = Horario::where('medico_id', $medico->id)->findOrFail($id);

        $horario->update([
            'dia_semana' => $request->dia_semana,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'consultorio' => $request->consultorio ?? 'No asignado',
            'estado' => $request->estado,
        ]);

        return redirect()
            ->route('medico.horarios.index')
            ->with('success', 'Horario actualizado correctamente.');
    }
}
