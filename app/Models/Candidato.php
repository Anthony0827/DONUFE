<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Candidato extends Authenticatable
{
    // Especifica el nombre de la tabla en la base de datos
    protected $table = "candidatos";
    
    // Define la clave primaria de la tabla
    protected $primaryKey = 'idcandidato';

    // Configura la clave primaria como INT autoincrementable
    public $incrementing = true; // Cambiado a true para autoincremento
    protected $keyType = 'int'; // Cambiado a 'int' para que sea de tipo entero

    // Especifica los atributos que se pueden asignar en masa
    protected $fillable = [
        'nombres', 'apellidos', 'clave', 'email', 'telefono', 'sexo', 'idrangoedad', 'idprovincia', 
        'localidad_id', 'fecharegistro', 'ideducacion', 'idsituacion', 'idperfil', 'iddepartamento', 'idexperiencia', 'idempresa', 'invitacion_enviada', 'bournout_completado', 'test_completado'
    ];

    // Indica que el modelo debe gestionar automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Relaciones con otras tablas
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'idprovincia');
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    public function educacion()
    {
        return $this->belongsTo(Educacion::class, 'educacion_id');
    }

    public function situacion()
    {
        return $this->belongsTo(Situacion::class, 'situacion_id');
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }
public function departamento()
{
    return $this->belongsTo(Departamento::class, 'iddepartamento');
}


    public function experiencia()
    {
        return $this->belongsTo(Experiencia::class, 'experiencia_id');
    }

    public function rangoEdad()
    {
        return $this->belongsTo(RangoEdad::class, 'idrangoedad');
    }
}
