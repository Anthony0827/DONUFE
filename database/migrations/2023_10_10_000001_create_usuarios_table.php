<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->uuid('idcandidato')->primary();
            $table->string('email')->unique();
            $table->string('clave');
            $table->string('recuperacion_token')->nullable();
            $table->timestamp('recuperacion_validohasta')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}