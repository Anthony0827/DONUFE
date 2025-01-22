<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Productividad extends Model
{
    protected $table = 'productividad';

    public $incrementing = false; // Deshabilita autoincremento para el UUID

    protected $keyType = 'string'; // Especifica que la clave primaria es de tipo string

    protected $fillable = [
        'idcandidato',
        'registro',
        'flujo',
        'titulo',
        'mensaje',
        'prioridad',
        'fechabacklog',
        // otros campos
    ];

    // Genera automáticamente el UUID para el campo `id`
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
