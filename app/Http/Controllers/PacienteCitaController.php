<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class PacienteCitaController extends Controller
{
    public function index()
    {
        // Traemos de la BD real SOLO los horarios que los médicos marcaron como "disponible".
        // Cargamos las relaciones para saber qué médico y especialidad es.
        $disponibilidades = Horario::with(['medico.user', 'medico.especialidad'])
            ->where('estado', 'disponible')
            ->latest()
            ->get();

        return view('paciente.citas.index', compact('disponibilidades'));
    }

    public function reservar($id)
    {
        // Buscamos el horario real en SQLite
        $horario = Horario::findOrFail($id);

        // Verificamos que siga disponible por seguridad
        if ($horario->estado === 'disponible') {

            // Actualizamos la base de datos para que ya nadie más pueda reservarlo
            $horario->update([
                'estado' => 'no_disponible'
            ]);

            return redirect()
                ->route('paciente.citas.index')
                ->with('success', '¡Cita reservada correctamente! El horario ha sido asignado.');
        }

        return redirect()
            ->route('paciente.citas.index')
            ->withErrors('Lo sentimos, este horario ya fue reservado por otro paciente.');
    }
}
