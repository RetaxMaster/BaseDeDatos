<?php

namespace App\Imports;

use App\Claro;
use App\Personas;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClaroImport implements ToModel, WithHeadingRow {
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row) {
        if (isset($row["documento"]) && $row["documento"] != NULL) {

            //Verifico si la persona no existe en la tabla Personas a través de su documento
            $persona = Personas::where("documento", "=", $row["documento"])->first();

            //Si aún no existe la inserto y la traigo
            if ($persona == NULL){
                $persona = Personas::add($row["documento"], $row["nombre"], $row["apellido"]);
            }
            
            
            //Recorremos cada columna
            $database_array = array();
            $keys_that_we_dont_insert = ["nombres", "apellido", "nombre", "documento"];

            foreach ($row as $key => $value) {
                //Algunas keys no las insertaremos, por lo que hacemos la validación
                if(!in_array($key, $keys_that_we_dont_insert)) $database_array[$key] = ($value == NULL) ? "" : $value;
            }

            $database_array["persona"] = $persona->id;
            
            return new Claro($database_array);

        }
        
    }
}