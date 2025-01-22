<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->char('idcandidato', 36)->primary();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('email')->unique();
            $table->string('clave');
            $table->unsignedBigInteger('iddepartamento');
            $table->integer('situacionregistro')->default(1);
            // ...existing code...
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatos');
    }
}
