<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasDirectasTable extends Migration
{
    public function up()
    {
        Schema::create('respuestas_directas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregunta_id')->constrained('preguntas');
            $table->string('respuesta_texto');
            $table->uuid('idcandidato');
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuestas_directas');
    }
}