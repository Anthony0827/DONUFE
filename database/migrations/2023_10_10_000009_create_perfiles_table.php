<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilesTable extends Migration
{
    public function up()
    {
        Schema::create('perfiles', function (Blueprint $table) {
            $table->uuid('idperfil')->primary();
            $table->string('perfil');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfiles');
    }
}