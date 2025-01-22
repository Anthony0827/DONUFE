<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    // Nombre de la tabla personalizado
    protected $table = 'respuestas';

    // Atributos que se pueden asignar masivamente
    protected $fillable = ['pregunta_id', 'respuesta_texto'];

    // Relación inversa con pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }

    // Relación con respuestas ordenadas
    public function respuestasOrdenadas()
    {
        return $this->hasMany(RespuestaOrdenada::class, 'respuesta_id');
    }
}
