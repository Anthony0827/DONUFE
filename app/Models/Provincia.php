<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Provincia extends Model
{
    // Puedes definir las propiedades si es necesario
    protected $table = 'ubica_provincia'; // El nombre de la tabla en la base de datos


      // Especifica los atributos que pueden asignar en masa
    protected $fillable = ['provincia'];
    
    // Define la clave primaria de la tabla
    protected $primaryKey = 'idprovincia';
    
    // Indica que la clave primaria no es un entero autoincremental
    public $incrementing = false;

    // Define el tipo de la clave primaria como string
    protected $keyType = 'string';

    // Indica que el modelo no debe gestionar automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Define una relación de tipo "tiene muchos" con el modelo Citas
    public function candidatos(): HasMany
    {
        return $this->hasMany(Candidato::class, 'provincia', 'idprovincia');
    }

      public function localidades()
    {
        return $this->hasMany(Localidad::class, 'idprovincia');
    }
}

