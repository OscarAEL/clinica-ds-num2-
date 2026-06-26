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

            // Ciclo de vida de la solicitud
            $table->string('estado')->default('pendiente');
            // valores esperados: pendiente | aprobada | rechazada | cancelada

            // Texto libre del paciente al solicitar (Paso 5 del wizard)
            $table->text('motivo_consulta')->nullable();

            // Texto del médico si rechaza (se usará en Fase 4)
            $table->text('motivo_rechazo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
