<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\MedicoPanelController;
use App\Http\Controllers\HorarioMedicoController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MedicoCitaController;
use App\Http\Controllers\PacienteCitaController;
use App\Http\Controllers\PacienteMedicoController;
use App\Http\Controllers\PacienteEspecialidadController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'mostrarLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])
    ->name('registro');

Route::post('/registro', [AuthController::class, 'registrar'])
    ->name('registro.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/inicio', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::resource('/admin/medicos', MedicoController::class)
        ->names('admin.medicos')
        ->except(['show']);

    Route::resource('/admin/especialidades', EspecialidadController::class)
        ->names('admin.especialidades')
        ->except(['show']);

    Route::get('/admin/usuarios', [UsuarioController::class, 'index'])
        ->name('admin.usuarios.index');

    Route::get('/admin/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])
        ->name('admin.usuarios.edit');

    Route::put('/admin/usuarios/{usuario}', [UsuarioController::class, 'update'])
        ->name('admin.usuarios.update');

    Route::delete('/admin/usuarios/{usuario}', [UsuarioController::class, 'destroy'])
        ->name('admin.usuarios.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/medico/inicio', [MedicoPanelController::class, 'home'])
        ->name('medico.home');

    Route::get('/medico/perfil', [MedicoPanelController::class, 'perfil'])
        ->name('medico.perfil');

    Route::put('/medico/perfil', [MedicoPanelController::class, 'actualizarPerfil'])
        ->name('medico.perfil.update');

    Route::get('/medico/citas', [MedicoCitaController::class, 'index'])
        ->name('medico.citas.index');

    Route::post('/medico/citas', [MedicoCitaController::class, 'store'])
        ->name('medico.citas.store');

    Route::get('/medico/citas/{disponibilidad}/edit', [MedicoCitaController::class, 'edit'])
        ->name('medico.citas.edit');

    Route::put('/medico/citas/{disponibilidad}', [MedicoCitaController::class, 'update'])
        ->name('medico.citas.update');

    Route::delete('/medico/citas/{disponibilidad}', [MedicoCitaController::class, 'destroy'])
        ->name('medico.citas.destroy');

    Route::resource('/medico/horarios', HorarioMedicoController::class)
        ->names('medico.horarios')
        ->except(['show']);
});

Route::middleware(['auth'])->group(function () {

    Route::get('/paciente/inicio', function () {
        return view('paciente.home');
    })->name('paciente.home');

    Route::get('/paciente/citas', [PacienteCitaController::class, 'index'])
        ->name('paciente.citas.index');

    Route::post('/paciente/citas/{disponibilidad}/reservar', [PacienteCitaController::class, 'reservar'])
        ->name('paciente.citas.reservar');

    Route::get('/paciente/medicos', [PacienteMedicoController::class, 'index'])
        ->name('paciente.medicos.index');

    Route::get('/paciente/especialidades', [PacienteEspecialidadController::class, 'index'])
        ->name('paciente.especialidades.index');
});