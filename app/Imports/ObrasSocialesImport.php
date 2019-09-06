<?php

namespace App\Imports;

use App\ObrasSociales;
use App\Personas;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default("none");
class ObrasSocialesImport implements ToModel, WithHeadingRow {
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    protected $excel_file;

    public function __construct($excel_file) {
        //Esto es en caso de que suba un archivo equivocado, lanzará un error, pero por el die() no se borrará el archivo, entonces lo borramos desde aquí
        $this->excel_file = $excel_file;
    }

    public function model(array $row) {
        try {
            if (isset($row["CuilTitular"]) && $row["CuilTitular"] != NULL) {

                //Esta tabla en específico no tiene documento, pero tiene cuil, el cual tiene un numero atras, el documento y dos numero adelante
                $documento = substr($row["CuilTitular"], 1, -2);

                //Verifico si la persona no existe en la tabla Personas a través de su documento
                $persona = Personas::where("documento", "=", $documento)->first();
    
                //Si aún no existe la inserto y la traigo
                if ($persona == NULL){
                    $persona = Personas::add($documento, $row["CuilTitularApeNom"]);
                }
                
                
                //Recorremos cada columna
                $database_array = array();
                $keys_that_we_dont_insert = ["CuilTitularApeNom"];
    
                foreach ($row as $key => $value) {
                    //Algunas keys no las insertaremos, por lo que hacemos la validación
                    if(!in_array($key, $keys_that_we_dont_insert)) $database_array[$key] = ($value == NULL) ? "" : $value;
                }

                
                $database_array["persona"] = $persona->id;
                return new ObrasSociales($database_array);
            }
        }
        catch (\Exception $e) {
            $response["status"] = "false";
            $response["message"] = "Ha surgido un error, probablemente hayas subido el archivo en la tabla equivocada o las columnas del archivo no coincide con las columnas de la base de datos. Mensaje: ". $e->getMessage();
            File::delete($this->excel_file);
            die(json_encode($response));
        }
    }
}
