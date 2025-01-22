
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatosExperienciaTable extends Migration
{
    public function up()
    {
        Schema::create('candidatos_experiencia', function (Blueprint $table) {
            $table->uuid('idexperiencia')->primary();
            $table->string('experiencia');
            $table->text('descripcion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidatos_experiencia');
    }
}