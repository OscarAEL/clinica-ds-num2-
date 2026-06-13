<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    // Le indicamos el nombre exacto de la tabla para evitar el "especialidads"
    protected $table = 'especialidades';

    // Los campos que vamos a permitir guardar desde el formulario
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];
}