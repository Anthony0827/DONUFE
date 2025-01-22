<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaOrdenada extends Model
{
    use HasFactory;

    // Nombre de la tabla personalizado
    protected $table = 'respuestas_ordenadas';

    // Atributos que se pueden asignar masivamente
 protected $fillable = ['pregunta_id', 'respuesta_id', 'orden', 'valor','feedback','idcandidato'];

    // Relación con pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }

    // Relación con respuesta
    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class, 'respuesta_id');
    }
}
