<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Especialidad;
use App\Models\Horario;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteCitaController extends Controller
{
    public function index()
    {
        $especialidades = Especialidad::where('estado', 'activo')
            ->orderBy('nombre')
            ->get();

        $medicos = Medico::with(['especialidad'])
            ->where('estado', 'activo')
            ->orderBy('nombres')
            ->get();

        $horarios = Horario::with(['medico'])
            ->where('estado', 'disponible')
            ->get();

        // Fechas ya reservadas o reprogramadas por horario para bloquearlas en el paso 4
        $citasReservadas = Cita::whereIn('estado', ['reservada', 'reprogramada'])
            ->get(['horario_id', 'fecha'])
            ->groupBy('horario_id')
            ->map(fn($group) => $group->pluck('fecha')->map(fn($f) => \Carbon\Carbon::parse($f)->toDateString())->toArray());

        return view('paciente.citas.index', compact('especialidades', 'medicos', 'horarios', 'citasReservadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'horario_id'      => 'required|exists:horarios,id',
            'fecha'           => 'required|date|after_or_equal:today',
            'motivo_consulta' => 'nullable|string|max:500',
        ]);

        // Verificar que ese horario no esté ya reservado para esa fecha exacta
        $existente = Cita::where('horario_id', $request->horario_id)
            ->whereDate('fecha', $request->fecha)
            ->whereIn('estado', ['reservada', 'reprogramada'])
            ->first();

        if ($existente) {
            return back()->withErrors([
                'fecha' => 'Este horario ya está reservado para esa fecha. Por favor elige otra fecha.'
            ]);
        }

        Cita::create([
            'paciente_id'     => Auth::id(),
            'horario_id'      => $request->horario_id,
            'fecha'           => $request->fecha,
            'estado'          => 'reservada',
            'motivo_consulta' => $request->motivo_consulta,
        ]);

        return redirect()
            ->route('paciente.citas.index')
            ->with('success', '¡Tu cita ha sido reservada correctamente!');
    }

    public function misCitas()
    {
        $citas = Cita::with([
            'horario.medico.especialidad',
        ])
            ->where('paciente_id', Auth::id())
            ->orderByDesc('fecha')
            ->orderByDesc('created_at')
            ->get();

        return view('paciente.mis-citas.index', compact('citas'));
    }
}
