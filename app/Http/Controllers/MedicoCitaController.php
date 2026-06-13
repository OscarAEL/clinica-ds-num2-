<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MedicoCitaController extends Controller
{
    private string $clave = 'disponibilidades_clinica';

    private function validarMedico()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'medico') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    private function obtenerDisponibilidades()
    {
        if (!Cache::has($this->clave)) {
            Cache::put($this->clave, [
                [
                    'id' => 1,
                    'medico' => Auth::user()->name ?? 'Médico',
                    'correo_medico' => Auth::user()->email,
                    'especialidad' => 'Medicina General',
                    'dia' => 'Lunes',
                    'fecha' => '2026-06-15',
                    'hora_inicio' => '08:00',
                    'hora_fin' => '12:00',
                    'lugar' => 'Segundo piso',
                    'laboratorio' => 'Laboratorio A',
                    'estado' => 'disponible',
                    'paciente' => null,
                    'correo_paciente' => null,
                ],
            ], now()->addDays(7));
        }

        return Cache::get($this->clave, []);
    }

    private function guardarDisponibilidades(array $disponibilidades)
    {
        Cache::put($this->clave, array_values($disponibilidades), now()->addDays(7));
    }

    public function index()
    {
        $this->validarMedico();

        $disponibilidades = collect($this->obtenerDisponibilidades())
            ->filter(fn ($item) => $item['correo_medico'] === Auth::user()->email)
            ->map(fn ($item) => (object) $item);

        return view('medico.citas.index', compact('disponibilidades'));
    }

    public function store(Request $request)
    {
        $this->validarMedico();

        $request->validate([
            'especialidad' => 'required|string|max:100',
            'dia' => 'required|string|max:30',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'lugar' => 'required|string|max:100',
            'laboratorio' => 'required|string|max:100',
        ]);

        $disponibilidades = $this->obtenerDisponibilidades();

        $nuevoId = empty($disponibilidades)
            ? 1
            : max(array_column($disponibilidades, 'id')) + 1;

        $disponibilidades[] = [
            'id' => $nuevoId,
            'medico' => Auth::user()->name,
            'correo_medico' => Auth::user()->email,
            'especialidad' => $request->especialidad,
            'dia' => $request->dia,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'lugar' => $request->lugar,
            'laboratorio' => $request->laboratorio,
            'estado' => 'disponible',
            'paciente' => null,
            'correo_paciente' => null,
        ];

        $this->guardarDisponibilidades($disponibilidades);

        return redirect()
            ->route('medico.citas.index')
            ->with('success', 'Horario disponible registrado correctamente.');
    }

    public function edit($id)
    {
        $this->validarMedico();

        $disponibilidad = collect($this->obtenerDisponibilidades())
            ->firstWhere('id', (int) $id);

        if (!$disponibilidad || $disponibilidad['correo_medico'] !== Auth::user()->email) {
            return redirect()
                ->route('medico.citas.index')
                ->with('error', 'No puedes editar este horario.');
        }

        return view('medico.citas.edit', [
            'disponibilidad' => (object) $disponibilidad
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validarMedico();

        $request->validate([
            'especialidad' => 'required|string|max:100',
            'dia' => 'required|string|max:30',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'lugar' => 'required|string|max:100',
            'laboratorio' => 'required|string|max:100',
            'estado' => 'required|in:disponible,reservado',
        ]);

        $disponibilidades = $this->obtenerDisponibilidades();

        foreach ($disponibilidades as $index => $item) {
            if ((int) $item['id'] === (int) $id && $item['correo_medico'] === Auth::user()->email) {
                $disponibilidades[$index]['especialidad'] = $request->especialidad;
                $disponibilidades[$index]['dia'] = $request->dia;
                $disponibilidades[$index]['fecha'] = $request->fecha;
                $disponibilidades[$index]['hora_inicio'] = $request->hora_inicio;
                $disponibilidades[$index]['hora_fin'] = $request->hora_fin;
                $disponibilidades[$index]['lugar'] = $request->lugar;
                $disponibilidades[$index]['laboratorio'] = $request->laboratorio;
                $disponibilidades[$index]['estado'] = $request->estado;
            }
        }

        $this->guardarDisponibilidades($disponibilidades);

        return redirect()
            ->route('medico.citas.index')
            ->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy($id)
    {
        //
    }
}