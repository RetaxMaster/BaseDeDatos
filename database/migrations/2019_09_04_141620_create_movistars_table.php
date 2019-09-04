<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovistarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movistars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("idcontrato");
            $table->string("imei");
            $table->string("tipodoc");
            $table->string("numerodoc");
            $table->string("cuil");
            $table->string("nombre");
            $table->string("apellido");
            $table->string("sexo");
            $table->string("idcliente");
            $table->string("alias");
            $table->string("telefono");
            $table->string("rol");
            $table->string("tipo");
            $table->string("movil");
            $table->string("estado");
            $table->string("direccion");
            $table->string("localidad");
            $table->string("provincia");
            $table->string("cp");
            $table->string("cpa");
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
        Schema::dropIfExists('movistars');
    }
}
