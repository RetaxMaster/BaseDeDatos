<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGaliciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galicias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("telefono");
            /* $table->string("nombres");
            $table->string("documento"); */
            $table->bigInteger("persona")->unsigned(); // <- Foreign
            $table->string("tel_fijo");
            $table->decimal("importe");
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
        Schema::dropIfExists('galicias');
    }
}
