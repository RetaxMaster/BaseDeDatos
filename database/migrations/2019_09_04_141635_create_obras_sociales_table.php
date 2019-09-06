<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObrasSocialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras_sociales', function (Blueprint $table) {
            $table->bigIncrements('id');
            /* $table->string("documento"); */
            $table->bigInteger("persona")->unsigned(); // <- Foreign
            $table->string("CuilTitular");
            $table->string("CuilTitularCodOS");
            $table->string("CuilTitularOS");
            $table->string("PeriodoDesde");
            /* $table->string("CuilTitularApeNom"); */
            $table->string("CuilTitularSexo");
            $table->string("CuilTitularFechaNacimiento");
            $table->string("CuilTitularCalle");
            $table->string("CuilTitularNro");
            $table->string("CuilTitularPiso");
            $table->string("CuilTitularDpto");
            $table->string("CuilTitularCodPostal");
            $table->string("CuilTitularLocalidad");
            $table->string("CuilTitularPcia");
            $table->string("CuilRelacionado");
            $table->string("Relacion");
            $table->string("CuilRelacionadoApeNom");
            $table->string("CuilRelacionadoSexo");
            $table->string("CuilRelacionadoFechaNacimiento");
            $table->string("CuilRelacionadoCalle");
            $table->string("CuilRelacionadoNro");
            $table->string("CuilRelacionadoPiso");
            $table->string("CuilRelacionadoDepto");
            $table->string("CuilRelacionadoCodPostal");
            $table->string("CuilRelacionadoLocalidad");
            $table->string("CuilRelacionadoPcia");
            $table->string("CuilTitularTEL");
            $table->string("CuilRelacionadoTEL");
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
        Schema::dropIfExists('obras_sociales');
    }
}
