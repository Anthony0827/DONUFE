
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatosEducacionTable extends Migration
{
    public function up()
    {
        Schema::create('candidatos_educacion', function (Blueprint $table) {
            $table->uuid('ideducacion')->primary();
            $table->string('abreviacion');
            $table->text('descripcion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidatos_educacion');
    }
}