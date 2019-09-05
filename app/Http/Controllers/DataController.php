<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\RetaxMaster;

use App\Claro;
use App\Galicia;
use App\Imports\ClaroImport;
use App\Jubilados;
use App\Macro;
use App\Movistar;
use App\ObrasSociales;
use App\Personal;
use App\Personas;
use Maatwebsite\Excel\Facades\Excel;

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
                $response["name"] = $file["name"];

                //Lo subimos a la base de datos
                $table = request("table");
                

            } else {
                $response["status"] = "false";
                $response["message"] .= "El prototipo no pudo ser subido de acuerdo al siguiente error: " . $file["message"] . "<br>";
            }
        }
        else {
            $response["status"] = "false";
            $response["message"] .= "No se ha subido ningún archivo";
        }

        return json_encode($response);
    }

    //Test Route
    public function test() {
        Personas::truncate();
        Claro::truncate();
        Excel::import(new ClaroImport, public_path()."/media/ExcelFiles/claro.xlsx");
        

    }

}
