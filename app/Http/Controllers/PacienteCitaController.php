<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PacienteCitaController extends Controller
{
    private string $clave = 'disponibilidades_clinica';

    private function validarPaciente()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'paciente') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    public function index()
    {
        $this->validarPaciente();

        $disponibilidades = collect(Cache::get($this->clave, []))
            ->map(fn ($item) => (object) $item);

        return view('paciente.citas.index', compact('disponibilidades'));
    }

    public function reservar($id)
    {
        $this->validarPaciente();

        $disponibilidades = Cache::get($this->clave, []);

        foreach ($disponibilidades as $index => $item) {
            if ((int) $item['id'] === (int) $id && $item['estado'] === 'disponible') {
                $disponibilidades[$index]['estado'] = 'reservado';
                $disponibilidades[$index]['paciente'] = Auth::user()->name;
                $disponibilidades[$index]['correo_paciente'] = Auth::user()->email;
            }
        }

        Cache::put($this->clave, $disponibilidades, now()->addDays(7));

        return redirect()
            ->route('paciente.citas.index')
            ->with('success', 'Cita reservada correctamente.');
    }
}