<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("linea");
            $table->string("producto");
            $table->string("tipo_doc");
            /* $table->string("documento"); */
            $table->bigInteger("persona")->unsigned(); // <- Foreign
            $table->string("provincia");
            $table->string("localidad");
            /* $table->string("nombre"); */
            $table->string("domicilio");
            $table->string("cp");
            $table->timestamps();
            $table->foreign("persona")->references("id")->on("personas");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personals');
    }
}
