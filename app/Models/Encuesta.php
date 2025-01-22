<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;

    // Nombre de la tabla personalizado
    protected $table = 'encuestas';

    // Atributos que se pueden asignar masivamente
    protected $fillable = ['titulo'];

    // Relación con preguntas
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'encuesta_id');
    }
}
