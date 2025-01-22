<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class RangoEdad extends Model

{
      use HasUuids;
    // Puedes definir las propiedades si es necesario
    protected $table = 'candidatos_rango_edad'; // El nombre de la tabla en la base de datos

     
    
    // Especifica los atributos que pueden asignar en masa
    protected $fillable = [ 'rangoedad'];
    
    // Define la clave primaria de la tabla
    protected $primaryKey = 'idrangoedad';
    
    // Indica que la clave primaria no es un entero autoincremental
    public $incrementing = false;

    // Define el tipo de la clave primaria como string
    protected $keyType = 'string';

    // Indica que el modelo no debe gestionar automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    
    public function candidatos(): HasMany
    {
        return $this->hasMany(Candidato::class, 'rangoedad', 'idrangoedad');
    }
}
