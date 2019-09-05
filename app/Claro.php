<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Claro extends Model {
    protected $fillable = ["telefono", "cel2", "c2", "c3", "c4", "calle", "nro", "piso", "dto", "localidad", "cp1", "cp2", "c15", "cuit", "persona", "c18", "c19", "c20", "c21", "c22", "c23", "c24"];

    public static function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::table("claros")->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }
}
