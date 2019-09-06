<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Claro;
use App\Galicia;
use App\Jubilados;
use App\Macro;
use App\Movistar;
use App\ObrasSociales;
use App\Personal;

class Personas extends Model {
    protected $fillable = ["documento", "nombre", "apellidos"];
    protected $hidden = ["id", "created_at", "updated_at"];

    public static function add($documento, $nombre, $apellido = null) {
        if ($apellido == null) {
            $nombre = explode(" ", $nombre);
            
            switch (count($nombre)) {
                case 1: // Solo está su primer nombre
                    $nombre = $nombre[0];
                    $apellido = "";
                    break;

                case 2: // Solo está un apellido y un nombre
                    $apellido = $nombre[0];
                    $nombre = $nombre[1];
                    break;

                case 3: // Dos apellidos y un nombre
                    $apellido = $nombre[0]." ".$nombre[1];
                    $nombre = $nombre[2];
                    break;
                
                default: //Dos apellidos y varios nombres
                    $apellido = $nombre[0]." ".$nombre[1];
                    unset($nombre[0]);
                    unset($nombre[1]);
                    $nombre = implode(" ", $nombre);
                    break;
            }
        }

        return parent::create([
            "documento" => (string) $documento,
            "nombre" => $nombre,
            "apellidos" => $apellido
        ]);
    }

    public static function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::table("personas")->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    // Relaciones
    
    public function claros() {
        return $this->hasMany(Claro::class, "persona");
    }

    public function galicias() {
        return $this->hasMany(Galicia::class, "persona");
    }

    public function jubilados() {
        return $this->hasMany(Jubilados::class, "persona");
    }

    public function macros() {
        return $this->hasMany(Macro::class, "persona");
    }

    public function movistars() {
        return $this->hasMany(Movistar::class, "persona");
    }

    public function obras_sociales() {
        return $this->hasMany(ObrasSociales::class, "persona");
    }

    public function personals() {
        return $this->hasMany(Personal::class, "persona");
    }
    
    // -> Relaciones
}
