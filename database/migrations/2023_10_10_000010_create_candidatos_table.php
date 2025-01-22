<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatosTable extends Migration
{
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id('idcandidato');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefono');
            $table->string('sexo');
            $table->uuid('idrangoedad');
            $table->uuid('idprovincia');
            $table->foreignId('localidad_id')->constrained('localidades');
            $table->foreignId('ideducacion')->constrained('educaciones');
            $table->uuid('idsituacion');
            $table->uuid('idperfil');
            $table->uuid('iddepartamento');
            $table->uuid('idexperiencia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidatos');
    }
}