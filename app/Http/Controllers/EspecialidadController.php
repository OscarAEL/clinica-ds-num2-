<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EspecialidadController extends Controller
{
    private function validarAdministrador()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'administrador') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    private function obtenerEspecialidades()
    {
        if (!session()->has('especialidades_admin')) {
            session()->put('especialidades_admin', [
                [
                    'id' => 1,
                    'nombre' => 'Cardiología',
                    'descripcion' => 'Atención de enfermedades del corazón.',
                    'estado' => 'activo',
                ],
                [
                    'id' => 2,
                    'nombre' => 'Pediatría',
                    'descripcion' => 'Atención médica para niños y adolescentes.',
                    'estado' => 'activo',
                ],
                [
                    'id' => 3,
                    'nombre' => 'Dermatología',
                    'descripcion' => 'Diagnóstico y tratamiento de la piel.',
                    'estado' => 'inactivo',
                ],
            ]);
        }

        return session('especialidades_admin', []);
    }

    private function guardarEspecialidades(array $especialidades)
    {
        session()->put('especialidades_admin', array_values($especialidades));
    }

    public function index()
    {
        $this->validarAdministrador();

        $especialidades = collect($this->obtenerEspecialidades())
            ->map(fn ($especialidad) => (object) $especialidad);

        return view('admin.especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        $this->validarAdministrador();

        return view('admin.especialidades.create');
    }

    public function store(Request $request)
    {
        $this->validarAdministrador();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $especialidades = $this->obtenerEspecialidades();

        $nuevoId = empty($especialidades)
            ? 1
            : max(array_column($especialidades, 'id')) + 1;

        $especialidades[] = [
            'id' => $nuevoId,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion ?? 'Sin descripción',
            'estado' => $request->estado,
        ];

        $this->guardarEspecialidades($especialidades);

        return redirect()
            ->route('admin.especialidades.index')
            ->with('success', 'Especialidad registrada correctamente.');
    }

    public function edit($id)
    {
        $this->validarAdministrador();

        $especialidad = collect($this->obtenerEspecialidades())
            ->firstWhere('id', (int) $id);

        if (!$especialidad) {
            return redirect()
                ->route('admin.especialidades.index')
                ->with('success', 'La especialidad seleccionada no existe.');
        }

        $especialidad = (object) $especialidad;

        return view('admin.especialidades.edit', compact('especialidad'));
    }

    public function update(Request $request, $id)
    {
        $this->validarAdministrador();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $especialidades = $this->obtenerEspecialidades();

        foreach ($especialidades as $index => $especialidad) {
            if ((int) $especialidad['id'] === (int) $id) {
                $especialidades[$index] = [
                    'id' => (int) $id,
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion ?? 'Sin descripción',
                    'estado' => $request->estado,
                ];
            }
        }

        $this->guardarEspecialidades($especialidades);

        return redirect()
            ->route('admin.especialidades.index')
            ->with('success', 'Especialidad actualizada correctamente.');
    }

    public function destroy($id)
    {
        $this->validarAdministrador();

        $especialidades = array_filter($this->obtenerEspecialidades(), function ($especialidad) use ($id) {
            return (int) $especialidad['id'] !== (int) $id;
        });

        $this->guardarEspecialidades($especialidades);

        return redirect()
            ->route('admin.especialidades.index')
            ->with('success', 'Especialidad eliminada correctamente.');
    }
}