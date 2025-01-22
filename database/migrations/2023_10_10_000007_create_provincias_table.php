<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvinciasTable extends Migration
{
    public function up()
    {
        Schema::create('provincias', function (Blueprint $table) {
            $table->uuid('idprovincia')->primary();
            $table->string('provincia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('provincias');
    }
}