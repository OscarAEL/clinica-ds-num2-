<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class PacienteMedicoController extends Controller
{
    public function index()
    {
        // Traemos de la BD real SOLO los médicos activos. 
        // Usamos 'with' para cargar también los datos de su cuenta de usuario (correo) y su especialidad.
        $medicos = Medico::with(['user', 'especialidad'])
            ->where('estado', 'activo')
            ->latest()
            ->get();

        return view('paciente.medicos.index', compact('medicos'));
    }
}
