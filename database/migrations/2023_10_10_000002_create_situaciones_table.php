<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSituacionesTable extends Migration
{
    public function up()
    {
        Schema::create('situaciones', function (Blueprint $table) {
            $table->uuid('idsituacion')->primary();
            $table->string('abreviacion');
            $table->string('descripcion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('situaciones');
    }
}