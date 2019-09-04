<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClarosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("telefono");
            $table->string("cel2");
            $table->string("c2");
            $table->string("c3");
            $table->string("c4");
            $table->string("nombres");
            $table->string("apellido");
            $table->string("nombre");
            $table->string("calle");
            $table->string("nro");
            $table->string("piso");
            $table->string("dto");
            $table->string("nro");
            $table->string("localidad");
            $table->string("cp1");
            $table->string("cp2");
            $table->string("c15");
            $table->string("cuit");
            $table->string("documento");
            $table->string("c18");
            $table->string("c19");
            $table->string("c20");
            $table->string("c21");
            $table->string("c22");
            $table->string("c23");
            $table->string("c24");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claros');
    }
}
