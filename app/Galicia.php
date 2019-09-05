<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galicia extends Model {
    protected $fillable = ["telefono", "persona", "tel_fijo", "importe"];

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
