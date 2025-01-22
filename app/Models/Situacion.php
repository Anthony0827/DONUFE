<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Situacion extends Model
{
    // Puedes definir las propiedades si es necesario
    protected $table = 'candidatos_situacion_laboral'; // El nombre de la tabla en la base de datos
          // Especifica los atributos que pueden asignar en masa
    protected $fillable = ['abreviacion','descripcion'];
    
    // Define la clave primaria de la tabla
    protected $primaryKey = 'idsituacion';
    
    // Indica que la clave primaria no es un entero autoincremental
    public $incrementing = false;

    // Define el tipo de la clave primaria como string
    protected $keyType = 'string';

    // Indica que el modelo no debe gestionar automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Define una relación de tipo "tiene muchos" con el modelo Citas
    public function candidatos(): HasMany
    {
        return $this->hasMany(Candidato::class, 'abreviacion','descripcion', 'idsituacion');
    }
}

