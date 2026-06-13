<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;

class PacienteEspecialidadController extends Controller
{
    public function index()
    {
        // Traemos de la BD real SOLO las especialidades que el Admin marcó como "activo"
        $especialidades = Especialidad::where('estado', 'activo')->latest()->get();

        return view('paciente.especialidades.index', compact('especialidades'));
    }
}
