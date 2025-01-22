<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Sector extends Model
{
    // Define el nombre de la tabla
    protected $table = 'sector';

    // Especifica los atributos que se pueden asignar en masa
    protected $fillable = ['nombre'];
    
    // Define la clave primaria de la tabla
    protected $primaryKey = 'idsector';
    
    // Indica que la clave primaria es un entero autoincremental
    public $incrementing = true;

    // Define el tipo de la clave primaria
    protected $keyType = 'int';

    // Indica que el modelo no debe gestionar automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    /**
     * Relación con el modelo Empresas.
     * Un sector tiene muchas empresas.
     */
    public function empresas(): HasMany
    {
        return $this->hasMany(Empresas::class, 'sector_id', 'idsector');
    }
}