
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductividadTable extends Migration
{
    public function up()
    {
        Schema::create('productividad', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('idcandidato');
            $table->string('registro');
            $table->string('flujo');
            $table->timestamp('fechabacklog')->nullable();
            $table->timestamp('fechaplanificada')->nullable();
            $table->timestamp('fechaprogreso')->nullable();
            $table->timestamp('fechabloqueo')->nullable();
            $table->timestamp('fechaterminada')->nullable();
            $table->string('titulo');
            $table->text('mensaje');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productividad');
    }
}