<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\MedicoPanelController;
use App\Http\Controllers\HorarioMedicoController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PacienteCitaController;
use App\Http\Controllers\PacienteMedicoController;
use App\Http\Controllers\PacienteEspecialidadController;
use App\Models\Medico;
use App\Models\Especialidad;
use App\Models\Cita;


// 1. RUTAS PÚBLICAS Y DE AUTENTICACIÓN

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// 2. RUTAS DEL ADMINISTRADOR

Route::middleware(['auth', 'role:administrador'])->group(function () {

    Route::get('/admin/inicio', function () {
        return view('admin.home', [
            'totalMedicos'        => \App\Models\Medico::where('estado', 'activo')->count(),
            'totalEspecialidades' => \App\Models\Especialidad::where('estado', 'activo')->count(),
            'totalUsuarios'       => \App\Models\User::count(),
        ]);
    })->name('admin.home');

    // Mantenimiento de Médicos 
    Route::resource('/admin/medicos', MedicoController::class)
        ->names('admin.medicos')
        ->except(['show', 'destroy']);

    // Mantenimiento de Especialidades
    Route::resource('/admin/especialidades', EspecialidadController::class)
        ->names('admin.especialidades')
        ->parameters(['especialidades' => 'especialidad'])
        ->except(['show', 'destroy']);

    // Gestión de Usuarios
    Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/admin/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/admin/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('admin.usuarios.update');
    Route::delete('/admin/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');
});



// 3. RUTAS COMPARTIDAS (ADMINISTRADOR Y MÉDICO)

Route::middleware(['auth', 'role:medico,administrador'])->group(function () {

    // Ambos perfiles pueden ver la lista de horarios (Index)
    Route::get('/medico/horarios', [HorarioMedicoController::class, 'index'])
        ->name('medico.horarios.index');
});


// 4. RUTAS DEL MÉDICO (Protegidas por Middleware)

Route::middleware(['auth', 'role:medico'])->group(function () {

    Route::get('/medico/inicio', [MedicoPanelController::class, 'home'])->name('medico.home');
    Route::get('/medico/perfil', [MedicoPanelController::class, 'perfil'])->name('medico.perfil');
    Route::put('/medico/perfil', [MedicoPanelController::class, 'actualizarPerfil'])->name('medico.perfil.update');

    // Gestión de citas del médico (Solo ver los turnos reservados)
    Route::get('/medico/citas', [MedicoPanelController::class, 'citas'])->name('medico.citas.index');

    Route::patch('/medico/citas/{cita}/cancelar', [MedicoPanelController::class, 'cancelarCita'])->name('medico.citas.cancelar');
    Route::patch('/medico/citas/{cita}/reprogramar', [MedicoPanelController::class, 'reprogramarCita'])->name('medico.citas.reprogramar');

    // Acciones de Horarios exclusivas para el médico (Crear, Editar, Eliminar)
    Route::get('/medico/horarios/create', [HorarioMedicoController::class, 'create'])->name('medico.horarios.create');
    Route::post('/medico/horarios', [HorarioMedicoController::class, 'store'])->name('medico.horarios.store');
    Route::get('/medico/horarios/{horario}/edit', [HorarioMedicoController::class, 'edit'])->name('medico.horarios.edit');
    Route::put('/medico/horarios/{horario}', [HorarioMedicoController::class, 'update'])->name('medico.horarios.update');
    Route::delete('/medico/horarios/{horario}', [HorarioMedicoController::class, 'destroy'])->name('medico.horarios.destroy');
});



// 5. RUTAS DEL PACIENTE (Protegidas por Middleware)

Route::middleware(['auth', 'role:paciente'])->group(function () {

    Route::get('/paciente/inicio', function () {
        $proximaCita = \App\Models\Cita::with(['horario.medico.especialidad'])
            ->where('paciente_id', auth()->id())
            ->where('estado', 'reservada')
            ->where('fecha', '>=', today())
            ->orderBy('fecha', 'asc')
            ->first();

        return view('paciente.home', compact('proximaCita'));
    })->name('paciente.home');

    Route::get('/paciente/citas', [PacienteCitaController::class, 'index'])->name('paciente.citas.index');
    Route::post('/paciente/citas', [PacienteCitaController::class, 'store'])->name('paciente.citas.store');
    Route::get('/paciente/mis-citas', [PacienteCitaController::class, 'misCitas'])->name('paciente.mis-citas.index');
    Route::post('/paciente/citas/{disponibilidad}/reservar', [PacienteCitaController::class, 'reservar'])->name('paciente.citas.reservar');

    Route::get('/paciente/medicos', [PacienteMedicoController::class, 'index'])->name('paciente.medicos.index');
    Route::get('/paciente/especialidades', [PacienteEspecialidadController::class, 'index'])->name('paciente.especialidades.index');
});
