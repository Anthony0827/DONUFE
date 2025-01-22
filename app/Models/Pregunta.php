<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    // Nombre de la tabla personalizado
    protected $table = 'preguntas';

    // Atributos que se pueden asignar masivamente
    protected $fillable = ['encuesta_id', 'pregunta_texto','orden','valor'];

    // Relación con respuestas
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id');
    }

    // Relación con respuestas ordenadas
    public function respuestasOrdenadas()
    {
        return $this->hasMany(RespuestaOrdenada::class, 'pregunta_id');
    }

    // Relación inversa con encuesta
    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class, 'encuesta_id');
    }
}
