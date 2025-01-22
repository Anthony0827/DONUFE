<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    // Eliminar el uso de UUIDs
    // use HasUuids; // No es necesario para idcandidato como INT

    protected $table = "usuarios"; // Asegúrate de que este sea el nombre correcto de la tabla
    protected $primaryKey = 'idcandidato'; // Mantener la clave primaria

    public $incrementing = true; // Cambiado a true para autoincremento
    protected $keyType = 'int'; // Cambiado a 'int' para que sea de tipo entero

    protected $fillable = [
        'name',
        'email',
        'password',
        'idcandidato', // Relación con el Candidato, debe ser de tipo INT
        'clave',
        'nombres',
        'apellidos',
        'departamento',
    ];

    public $timestamps = false;

    protected $hidden = [
        'clave',
        'recuperacion_token', // Ocultar el token en respuestas JSON
    ];

    public function getAuthIdentifier()
    {
        return $this->email;
    }

    public function getAuthPassword()
    {
        return $this->password; // Asegúrate de que este campo esté encriptado
    }

    public function getAuthIdentifierName()
    {
        return 'email';
    }

    public function candidato()
    {
        return $this->belongsTo(Candidato::class, 'idcandidato', 'idcandidato'); // Ajusta las claves si es necesario
    }
}
