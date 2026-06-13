<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'medico_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'consultorio',
        'estado'
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}
