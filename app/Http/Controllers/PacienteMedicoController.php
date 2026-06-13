<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PacienteMedicoController extends Controller
{
    private function validarPaciente()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'paciente') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    public function index()
    {
        $this->validarPaciente();

        if (!Cache::has('medicos_clinica_visual')) {
            Cache::put('medicos_clinica_visual', [
                [
                    'id' => 1,
                    'nombres' => 'Ramses',
                    'apellidos' => 'Alvarez',
                    'correo' => 'amedico@clinicads.com',
                    'telefono' => '949110492',
                    'especialidad' => 'Medicina General',
                    'posicion' => 'Médico general de atención primaria',
                    'biografia' => 'Profesional encargado de la atención médica inicial, orientación preventiva y evaluación general de pacientes de todas las edades.',
                    'estado' => 'activo',
                ],
                [
                    'id' => 2,
                    'nombres' => 'Juan',
                    'apellidos' => 'Eneque',
                    'correo' => 'medico@clinicads.com',
                    'telefono' => '987456123',
                    'especialidad' => 'Cardiología',
                    'posicion' => 'Cardiólogo clínico',
                    'biografia' => 'Especialista en evaluación, diagnóstico y seguimiento de enfermedades relacionadas con el corazón y el sistema cardiovascular.',
                    'estado' => 'activo',
                ],
            ], now()->addDays(7));
        }

        $medicos = collect(Cache::get('medicos_clinica_visual', []))
            ->map(fn ($medico) => (object) $medico);

        return view('paciente.medicos.index', compact('medicos'));
    }
}