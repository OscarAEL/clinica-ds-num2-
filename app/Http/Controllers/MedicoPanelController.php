<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Medico;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicoPanelController extends Controller
{
    private function obtenerMedico()
    {
        return Medico::where('user_id', Auth::id())->firstOrFail();
    }

    public function home()
    {
        $medico = $this->obtenerMedico();

        $citasHoy = Cita::whereHas('horario', function ($q) use ($medico) {
            $q->where('medico_id', $medico->id);
        })
            ->where('fecha', today())
            ->where('estado', 'reservada')
            ->count();

        $citasTotal = Cita::whereHas('horario', function ($q) use ($medico) {
            $q->where('medico_id', $medico->id);
        })
            ->where('estado', 'reservada')
            ->count();

        $horariosDisponibles = Horario::where('medico_id', $medico->id)
            ->where('estado', 'disponible')
            ->count();

        return view('medico.home', compact('citasHoy', 'citasTotal', 'horariosDisponibles'));
    }

    public function perfil()
    {
        $medico = $this->obtenerMedico();
        return view('medico.perfil', compact('medico'));
    }

    public function actualizarPerfil(Request $request)
    {
        $medico = $this->obtenerMedico();

        $request->validate([
            'nombres'   => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'dni'       => 'nullable|string|max:20',
            'telefono'  => 'nullable|string|max:20',
            'cmp'       => 'nullable|string|max:50',
        ]);

        $medico->update([
            'nombres'   => $request->nombres,
            'apellidos' => $request->apellidos,
            'dni'       => $request->dni,
            'telefono'  => $request->telefono,
            'cmp'       => $request->cmp,
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
        $medico = $this->obtenerMedico();

        // Citas reservadas en horarios de este médico
        $citas = Cita::with(['paciente', 'horario'])
            ->whereHas('horario', function ($q) use ($medico) {
                $q->where('medico_id', $medico->id);
            })
            ->orderBy('fecha', 'asc')
            ->get();

        return view('medico.citas.index', compact('citas'));
    }

    public function cancelarCita(Request $request, Cita $cita)
    {
        $request->validate([
            'motivo_cancelacion' => 'required|string|max:500',
        ]);

        // Verificar que la cita pertenece a un horario de este médico
        $medico = $this->obtenerMedico();
        if ($cita->horario->medico_id !== $medico->id) {
            abort(403);
        }

        $cita->update([
            'estado'              => 'cancelada',
            'motivo_cancelacion'  => $request->motivo_cancelacion,
        ]);

        return redirect()
            ->route('medico.citas.index')
            ->with('success', 'La cita ha sido cancelada y el paciente ha sido notificado.');
    }

    public function reprogramarCita(Request $request, Cita $cita)
    {
        $request->validate([
            'nueva_fecha'         => 'required|date|after_or_equal:today',
            'motivo_cancelacion'  => 'required|string|max:500',
        ]);

        $medico = $this->obtenerMedico();

        if ($cita->horario->medico_id !== $medico->id) {
            abort(403);
        }

        $existeCita = Cita::where('horario_id', $cita->horario_id)
            ->whereDate('fecha', $request->nueva_fecha)
            ->whereIn('estado', ['reservada', 'reprogramada'])
            ->where('id', '!=', $cita->id)
            ->exists();

        if ($existeCita) {
            return redirect()
                ->route('medico.citas.index')
                ->withInput()
                ->with('error', 'Ya existe una cita reservada para este horario en la fecha seleccionada.');
        }

        $cita->update([
            'estado'             => 'reprogramada',
            'fecha'              => $request->nueva_fecha,
            'motivo_cancelacion' => $request->motivo_cancelacion,
        ]);

        return redirect()
            ->route('medico.citas.index')
            ->with('success', 'La cita ha sido reprogramada correctamente.');
    }
}
