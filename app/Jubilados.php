<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jubilados extends Model {
    protected $fillable = ["titular_cuilbenef", "titular_cuilbenef_rep", "titular_nrobeneficio", "titular_tipodoc", "persona", "titular_pciadoc", "titular_fechanac", "titular_sexo", "titular_calle", "titular_callenro", "titular_piso", "titular_deptooficina", "titular_localidad", "titular_pcia", "titular_provincia", "titular_codpos", "titular_beneficioclase", "titular_periodoalta", "titular_fechainicpago", "titular_expediente", "titular_leyaplicada", "titular_bancosuc", "titular_beneficioppal", "titular_marcaaltaprpa", "titular_estado", "titular_fechafalleccausante","apoderado_fechaalta", "apoderado_fechavencim", "apoderado_codigo", "apoderado_bcosuc", "apoderado_apellidonombre", "apoderado_tipodoc", "apoderado_nrodoc", "apoderado_pciadoc", "apoderado_sexo", "apoderado_calle", "apoderado_callenro", "apoderado_piso", "apoderado_oficinadepto", "apoderado_localidad", "apoderado_pcia", "apoderado_provincia", "apoderado_codpos", "titular_bruto", "titular_neto"];

    public static function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::table("jubilados")->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    // Relaciones
    
    public function personinfo() {
        return $this->belongsTo(Personas::class, 'persona');
    }
    
    // -> Relaciones
    
}
