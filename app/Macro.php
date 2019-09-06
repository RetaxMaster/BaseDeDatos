<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Macro extends Model {
    protected $fillable = ["persona", "sexo", "clase", "domicilio", "provincia", "localidad", "partido", "cp", "cuil", "bcra_sit", "bcra_entidad", "cuit", "denominacion", "calle", "nro", "piso", "dto", "local_denom", "cp_denom", "provincia_denom", "monto", "tel_original", "tel1", "comp1", "tel2", "comp2", "tel3", "comp3", "tel4", "comp4", "tel5", "comp5", "tel6", "comp6", "tel7", "comp7", "tel8", "comp8", "fecha_nac", "email"];

    public static function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::table("macros")->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    // Relaciones
    
    public function personinfo() {
        return $this->belongsTo(Personas::class, 'persona');
    }
    
    // -> Relaciones
    
}
