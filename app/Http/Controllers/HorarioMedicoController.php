<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioMedicoController extends Controller
{
    private function validarMedico()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'medico') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    private function obtenerHorarios()
    {
        if (!session()->has('horarios_medico')) {
            session()->put('horarios_medico', [
                [
                    'id' => 1,
                    'dia_semana' => 'Lunes',
                    'hora_inicio' => '08:00',
                    'hora_fin' => '12:00',
                    'consultorio' => 'Consultorio 201',
                    'estado' => 'disponible',
                ],
                [
                    'id' => 2,
                    'dia_semana' => 'Miércoles',
                    'hora_inicio' => '14:00',
                    'hora_fin' => '18:00',
                    'consultorio' => 'Consultorio 305',
                    'estado' => 'disponible',
                ],
                [
                    'id' => 3,
                    'dia_semana' => 'Viernes',
                    'hora_inicio' => '09:00',
                    'hora_fin' => '13:00',
                    'consultorio' => 'Consultorio 102',
                    'estado' => 'no_disponible',
                ],
            ]);
        }

        return session('horarios_medico', []);
    }

    private function guardarHorarios(array $horarios)
    {
        session()->put('horarios_medico', array_values($horarios));
    }

    public function index()
    {
        $this->validarMedico();

        $horarios = collect($this->obtenerHorarios())
            ->map(function ($horario) {
                return (object) $horario;
            });

        return view('medico.horarios.index', compact('horarios'));
    }

    public function create()
    {
        $this->validarMedico();

        return view('medico.horarios.create');
    }

    public function store(Request $request)
    {
        $this->validarMedico();

        $request->validate([
            'dia_semana' => 'required|string|max:30',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'consultorio' => 'nullable|string|max:100',
            'estado' => 'required|in:disponible,no_disponible',
        ]);

        $horarios = $this->obtenerHorarios();

        $nuevoId = empty($horarios)
            ? 1
            : max(array_column($horarios, 'id')) + 1;

        $horarios[] = [
            'id' => $nuevoId,
            'dia_semana' => $request->dia_semana,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'consultorio' => $request->consultorio ?? 'No asignado',
            'estado' => $request->estado,
        ];

        $this->guardarHorarios($horarios);

        return redirect()
            ->route('medico.horarios.index')
            ->with('success', 'Horario registrado correctamente.');
    }

    public function edit($id)
    {
        $this->validarMedico();

        $horarios = $this->obtenerHorarios();

        $horarioEncontrado = collect($horarios)->firstWhere('id', (int) $id);

        if (!$horarioEncontrado) {
            return redirect()
                ->route('medico.horarios.index')
                ->with('success', 'El horario seleccionado no existe.');
        }

        $horario = (object) $horarioEncontrado;

        return view('medico.horarios.edit', compact('horario'));
    }

    public function update(Request $request, $id)
    {
        $this->validarMedico();

        $request->validate([
            'dia_semana' => 'required|string|max:30',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'consultorio' => 'nullable|string|max:100',
            'estado' => 'required|in:disponible,no_disponible',
        ]);

        $horarios = $this->obtenerHorarios();

        foreach ($horarios as $index => $horario) {
            if ((int) $horario['id'] === (int) $id) {
                $horarios[$index] = [
                    'id' => (int) $id,
                    'dia_semana' => $request->dia_semana,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin,
                    'consultorio' => $request->consultorio ?? 'No asignado',
                    'estado' => $request->estado,
                ];

                break;
            }
        }

        $this->guardarHorarios($horarios);

        return redirect()
            ->route('medico.horarios.index')
            ->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $this->validarMedico();

        $horarios = $this->obtenerHorarios();

        $horarios = array_filter($horarios, function ($horario) use ($id) {
            return (int) $horario['id'] !== (int) $id;
        });

        $this->guardarHorarios($horarios);

        return redirect()
            ->route('medico.horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }
}