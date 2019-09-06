<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movistar extends Model {
    protected $fillable = ["idcontrato", "imei", "tipodoc", "persona", "cuil", "sexo", "idcliente", "alias", "telefono", "rol", "tipo", "movil", "estado", "direccion", "localidad", "provincia", "cp", "cpa"];

    public static function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::table("movistars")->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    // Relaciones
    
    public function personinfo() {
        return $this->belongsTo(Personas::class, 'persona');
    }
    
    // -> Relaciones
    
}
