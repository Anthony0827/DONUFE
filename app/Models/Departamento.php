<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    // Puedes definir las propiedades si es necesario
    protected $table = 'departamentos'; // El nombre de la tabla en la base de datos

    // Especifica los atributos que pueden asignar en masa
    protected $fillable = ['departamento'];
    
    // Define la clave primaria de la tabla
    protected $primaryKey = 'iddepartamento';
    
    // Indica que la clave primaria es un entero autoincremental
    public $incrementing = true;

    // Define el tipo de la clave primaria como entero
    protected $keyType = 'int';

    // Indica que el modelo no debe gestionar automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Define una relación de tipo "tiene muchos" con el modelo Citas
    public function candidatos(): HasMany
    {
        return $this->hasMany(Candidato::class, 'departamento', 'iddepartamento');
    }
}


