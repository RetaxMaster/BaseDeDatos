<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\RetaxMaster;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

use App\Claro;
use App\Galicia;
use App\Jubilados;
use App\Macro;
use App\Movistar;
use App\ObrasSociales;
use App\Personal;
use App\Personas;

use App\Imports\ClaroImport;

class DataController extends Controller {

    //Muestra el panel de administrador
    public function showAdminPanel() {
        return view("admin");
    }

    //Muestra la sección de búsquedas
    public function showSearch() {
        return view("search");        
    }

    //Sube un archivo
    public function uploadFile() {
        if (request()->hasFile("ExcelFile")) {
            $file = RetaxMaster::uploadFile(request()->file("ExcelFile"), "ExcelFiles");
            if (isset($file["name"])) {
                $filename = $file["name"];
                $file_path = public_path() . "/media/ExcelFiles/$filename";

                
                //Lo subimos a la base de datos
                $table = request("Table");
                $insert = self::insertData($table, $file_path);
                
                //Borramos el archivo
                
                File::delete($file_path);

                if ($insert["status"]) {
                    $response["status"] = "true";
                }
                else {
                    $response["status"] = "false";
                    $response["message"] = $insert["message"];
                }

            } else {
                $response["status"] = "false";
                $response["message"] = "El prototipo no pudo ser subido de acuerdo al siguiente error: " . $file["message"] . "<br>";
            }
        }
        else {
            $response["status"] = "false";
            $response["message"] = "No se ha subido ningún archivo";
        }

        return json_encode($response);
    }

    public static function insertData($table, $file_path) {
        $response["status"] = true;
        switch ($table) {
            case 1:
                Claro::truncate();
                Excel::import(new ClaroImport($file_path), $file_path);
                break;

            case 2:
                Galicia::truncate();
                Excel::import(new GaliciaImport($file_path), $file_path);
                break;

            case 3:
                Jubilados::truncate();
                Excel::import(new JubiladosImport($file_path), $file_path);
                break;

            case 4:
                Macro::truncate();
                Excel::import(new MacroImport($file_path), $file_path);
                break;

            case 5:
                Movistar::truncate();
                Excel::import(new MovistarImport($file_path), $file_path);
                break;

            case 6:
                ObrasSociales::truncate();
                Excel::import(new ObrasSocialesImport($file_path), $file_path);
                break;

            case 7:
                Personal::truncate();
                Excel::import(new PersonalImport($file_path), $file_path);
                break;
            
            default:
                $response["status"] = false;
                $response["message"] = "No se ha encontrado la tabla";
                break;
        }

        return $response;
    }

    //Test Route
    public function test() {

    }

}
