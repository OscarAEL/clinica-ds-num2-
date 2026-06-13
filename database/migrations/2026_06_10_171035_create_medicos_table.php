<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni')->nullable();
            $table->string('telefono')->nullable();
            $table->foreignId('especialidad_id')->constrained('especialidades')->cascadeOnDelete();
            $table->string('cmp')->nullable();
            $table->string('estado')->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};