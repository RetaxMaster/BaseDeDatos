<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Personas extends Model {
    protected $fillable = ["documento", "nombre", "apellidos"];

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
}
