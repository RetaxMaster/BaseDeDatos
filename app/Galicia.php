<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Galicia extends Model {
    protected $fillable = ["telefono", "persona", "tel_fijo", "importe"];
    protected $hidden = ["id", "persona", "created_at", "updated_at"];

    public static function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::table("galicias")->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    // Relaciones
    
    public function personinfo() {
        return $this->belongsTo(Personas::class, 'persona');
    }
    
    // -> Relaciones
}
