<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();

            // Quién solicita la cita (un User con tipo_usuario = 'paciente')
            $table->foreignId('paciente_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Qué horario del médico está solicitando
            $table->foreignId('horario_id')
                ->constrained('horarios')
                ->cascadeOnDelete();

            // Estado actual de la cita dentro del flujo del sistema
            $table->string('estado')->default('reservada');
            // valores esperados: reservada | cancelada | reprogramada

            // Texto libre del paciente al solicitar la cita
            $table->text('motivo_consulta')->nullable();

            // Campo antiguo conservado para compatibilidad con migraciones/datos previos.
            // El flujo actual usa motivo_cancelacion, agregado en la migración update_citas_table.
            $table->text('motivo_rechazo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
