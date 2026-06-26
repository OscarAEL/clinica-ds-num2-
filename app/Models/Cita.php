<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'paciente_id',
        'horario_id',
        'fecha',
        'estado',
        'motivo_consulta',
        'motivo_cancelacion',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // estados válidos: reservada | cancelada | reprogramada

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
}
