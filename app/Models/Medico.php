<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $fillable = [
        'user_id',
        'nombres',
        'apellidos',
        'dni',
        'telefono',
        'especialidad_id',
        'cmp',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function nombreCompleto()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}
