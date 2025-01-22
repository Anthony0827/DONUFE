<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductividadesTable extends Migration
{
    public function up()
    {
        Schema::create('productividades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('idcandidato');
            $table->string('registro');
            $table->string('flujo');
            $table->string('titulo');
            $table->text('mensaje');
            $table->timestamp('fechabacklog');
            // ...existing code...
        });
    }

    public function down()
    {
        Schema::dropIfExists('productividades');
    }
}