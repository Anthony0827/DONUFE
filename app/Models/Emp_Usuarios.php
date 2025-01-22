<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Emp_Usuarios extends Authenticatable
{
    protected $table = "emp_usuarios";
    protected $primaryKey = 'idusuario';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'email',
        'clave',
        'telefono',
        'idempresa',
        'recuperacion_token',
        'recuperacion_validohasta',
    ];

    public $timestamps = false;

    protected $hidden = [
        'clave',
        'recuperacion_token',
    ];

    public function getAuthIdentifier()
    {
        return $this->email;
    }

    public function getAuthPassword()
    {
        return $this->clave;
    }

    public function getAuthIdentifierName()
    {
        return 'email';
    }
}