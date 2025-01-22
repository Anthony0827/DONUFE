
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('motivo');
            $table->text('comentario');
            $table->string('idcandidato');
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}