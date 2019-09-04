<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJubiladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jubilados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("titular_cuilbenef");
            $table->string("titular_cuilbenef_rep");
            $table->string("titular_nrobeneficio");
            $table->string("titular_apellidonombre");
            $table->string("titular_tipodoc");
            $table->string("titular_nrodoc");
            $table->string("titular_pciadoc");
            $table->string("titular_fechanac");
            $table->char("titular_sexo");
            $table->string("titular_calle");
            $table->string("titular_callenro");
            $table->integer("titular_piso");
            $table->integer("titular_deptooficina");
            $table->string("titular_localidad");
            $table->integer("titular_pcia");
            $table->string("titular_provincia");
            $table->string("titular_codpos");
            $table->string("titular_beneficioclase");
            $table->string("titular_periodoalta");
            $table->string("titular_fechainicpago");
            $table->string("titular_expediente");
            $table->string("titular_leyaplicada");
            $table->string("titular_bancosuc");
            $table->string("titular_beneficioppal");
            $table->string("titular_marcaaltaprpa");
            $table->string("titular_estado");
            $table->string("titular_fechafalleccausante");
            $table->string("apoderado_fechaalta");
            $table->string("apoderado_fechavencim");
            $table->string("apoderado_codigo");
            $table->string("apoderado_bcosuc");
            $table->string("apoderado_apellidonombre");
            $table->string("apoderado_tipodoc");
            $table->string("apoderado_nrodoc");
            $table->string("apoderado_pciadoc");
            $table->string("apoderado_sexo");
            $table->string("apoderado_calle");
            $table->string("apoderado_callenro");
            $table->string("apoderado_piso");
            $table->string("apoderado_oficinadepto");
            $table->string("apoderado_localidad");
            $table->string("apoderado_pcia");
            $table->string("apoderado_provincia");
            $table->string("apoderado_codpos");
            $table->decimal("titular_bruto");
            $table->decimal("titular_neto");
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
        Schema::dropIfExists('jubilados');
    }
}
