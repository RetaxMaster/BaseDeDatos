<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMacrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('macros', function (Blueprint $table) {
            $table->bigIncrements('id');
            /* $table->string("documento");
            $table->string("apellido");
            $table->string("nombre"); */
            $table->bigInteger("persona")->unsigned(); // <- Foreign
            $table->char("sexo");
            $table->string("clase");
            $table->string("domicilio");
            $table->string("provincia");
            $table->string("localidad");
            $table->string("partido");
            $table->string("cp");
            $table->string("cuil");
            $table->string("bcra_sit");
            $table->string("bcra_entidad");
            $table->string("cuit");
            $table->string("denominacion");
            $table->string("calle");
            $table->string("nro");
            $table->string("piso");
            $table->string("dto");
            $table->string("local_denom");
            $table->string("cp_denom");
            $table->string("provincia_denom");
            $table->decimal("monto");
            $table->string("tel_original");
            $table->string("tel1");
            $table->string("comp1");
            $table->string("tel2");
            $table->string("comp2");
            $table->string("tel3");
            $table->string("comp3");
            $table->string("tel4");
            $table->string("comp4");
            $table->string("tel5");
            $table->string("comp5");
            $table->string("tel6");
            $table->string("comp6");
            $table->string("tel7");
            $table->string("comp7");
            $table->string("tel8");
            $table->string("comp8");
            $table->string("fecha_nac");
            $table->string("email");
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
        Schema::dropIfExists('macros');
    }
}
