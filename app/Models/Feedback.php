<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'motivo',
        'comentario',
        'idcandidato',
    ];


        protected $primaryKey = 'id';

          // Indica que la clave primaria no es un entero autoincremental
    public $incrementing = false;

    // Define el tipo de la clave primaria como string
    protected $keyType = 'string';

    // Indica que el modelo no debe gestionar automáticamente las columnas created_at y updated_at
    public $timestamps = false;
}


