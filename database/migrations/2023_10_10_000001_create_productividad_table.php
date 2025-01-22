
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
            $table->string('idcandidato');
            $table->string('registro');
            $table->string('flujo');
            $table->string('titulo');
            $table->text('mensaje');
            $table->date('fechabacklog');
            // otros campos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productividad');
    }
}