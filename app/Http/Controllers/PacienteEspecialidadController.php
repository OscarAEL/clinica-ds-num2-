<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PacienteEspecialidadController extends Controller
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

        if (!Cache::has('especialidades_clinica_visual')) {
            Cache::put('especialidades_clinica_visual', [
                [
                    'id' => 1,
                    'nombre' => 'Medicina General',
                    'descripcion' => 'Atención médica inicial para diagnóstico, prevención y tratamiento de enfermedades comunes.',
                    'area' => 'Consultorios externos - Primer piso',
                    'estado' => 'activo',
                ],
                [
                    'id' => 2,
                    'nombre' => 'Cardiología',
                    'descripcion' => 'Especialidad encargada del diagnóstico y tratamiento de enfermedades del corazón y sistema circulatorio.',
                    'area' => 'Área de Cardiología - Segundo piso',
                    'estado' => 'activo',
                ],
                [
                    'id' => 3,
                    'nombre' => 'Pediatría',
                    'descripcion' => 'Atención médica especializada para bebés, niños y adolescentes.',
                    'area' => 'Área Pediátrica - Primer piso',
                    'estado' => 'activo',
                ],
                [
                    'id' => 4,
                    'nombre' => 'Dermatología',
                    'descripcion' => 'Diagnóstico y tratamiento de enfermedades de la piel, cabello y uñas.',
                    'area' => 'Consultorio de Dermatología - Segundo piso',
                    'estado' => 'activo',
                ],
                [
                    'id' => 5,
                    'nombre' => 'Traumatología',
                    'descripcion' => 'Atención de lesiones en huesos, músculos, articulaciones y sistema locomotor.',
                    'area' => 'Área de Traumatología - Tercer piso',
                    'estado' => 'activo',
                ],
            ], now()->addDays(7));
        }

        $especialidades = collect(Cache::get('especialidades_clinica_visual', []))
            ->map(fn ($especialidad) => (object) $especialidad);

        return view('paciente.especialidades.index', compact('especialidades'));
    }
}