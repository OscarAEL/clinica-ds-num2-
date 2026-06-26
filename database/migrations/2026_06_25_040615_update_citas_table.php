<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {

            // Fecha concreta de la cita (crítica: horarios son bloques semanales recurrentes)
            $table->date('fecha')->after('horario_id');

            // Para cancelaciones y reprogramaciones del médico
            $table->text('motivo_cancelacion')->nullable()->after('motivo_consulta');
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn(['fecha', 'motivo_cancelacion']);
        });
    }
};
