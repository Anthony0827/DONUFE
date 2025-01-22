<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Empresas extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $primaryKey = 'idempresa';
    public $timestamps = false;

    protected $fillable = [
        'idempresa', // <-- Agregar aquí
        'nombreEmpresa',
        'telefono',
        'cif',
        'tipoEmpresa',
        'direccion',
        'cp',
        'idprovincia',
        'idlocalidad',
        
        
    ];


    // Indica que el modelo debe gestionar automáticamente las columnas created_at y updated_at
  public function usuario()
{
    return $this->hasOne(Emp_Usuarios::class, 'idempresa', 'idempresa');
}
public function localidades()
{
    return $this->hasMany(Localidad::class, 'idprovincia', 'idprovincia');
}
 
}


