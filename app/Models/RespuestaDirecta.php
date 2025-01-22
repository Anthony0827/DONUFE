<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaDirecta extends Model
{
    use HasFactory;

     protected $table = 'respuestas_ordenadas';

    protected $fillable = ['pregunta_id', 'respuesta_texto','idcandidato'];

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