<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasOrdenadasTable extends Migration
{
    public function up()
    {
        Schema::create('respuestas_ordenadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregunta_id')->constrained('preguntas');
            $table->foreignId('respuesta_id')->constrained('respuestas');
            $table->integer('orden');
            $table->string('valor');
            $table->string('feedback')->nullable();
            $table->uuid('idcandidato');
            // ...existing code...
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuestas_ordenadas');
    }
}