<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use App\Classes\RetaxMaster;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Claro;
use App\Galicia;
use App\Jubilados;
use App\Macro;
use App\Movistar;
use App\ObrasSociales;
use App\Personal;
use App\Personas;

use App\Imports\ClaroImport;
use App\Imports\GaliciaImport;
use App\Imports\JubiladosImport;
use App\Imports\MacroImport;
use App\Imports\MovistarImport;
use App\Imports\ObrasSocialesImport;
use App\Imports\PersonalImport;

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

    //Inserta los datos a partir del archivo de Excel
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

    //Hace las consultas
    public function getData() {
        $query = request("query");
        $table = request("table");
        $limit = request("limit");
        $inner = request("inner");

        //Reviso en qué tabla se está buscando
        switch ($table) {
            case 1: $schema = "claros"; $model = "Claro"; break;
            case 2: $schema = "galicias"; $model = "Galicia"; break;
            case 3: $schema = "jubilados"; $model = "Jubilados"; break;
            case 4: $schema = "macros"; $model = "Macro"; break;
            case 5: $schema = "movistars"; $model = "Movistar"; break;
            case 6: $schema = "obras_sociales"; $model = "ObrasSociales"; break;
            case 7: $schema = "personals"; $model = "Personal"; break;
            default: $schema = null; break;
        }

        //Obtengo las columnas de esa tabla, y quito a la columna persona
        $columns = Schema::getColumnListing($schema);
        unset($columns[array_search("persona", $columns)]);
        $columns = array_values($columns);

        //Armo la consulta de Eloqeunt por medio de un string
        $eloquentQuery = '$results = '."App\\$model::";

        for ($i=0; $i < count($columns); $i++) { 
            if ($i != 0)
                $eloquentQuery .= "->orWhere('$columns[$i]', 'like', '%$query%')";
            else
                $eloquentQuery .= "where('$columns[$i]', 'like', '%$query%')";
            $i++;
        }

        $putLimit = $limit == null ? "" : "limit($limit)->";
        $eloquentQuery .= "->". $putLimit."get();";

        //Evaluo la consulta como codigo PHP
        eval($eloquentQuery);

        //A partir de aquí ya tengo los datos
        return json_encode($results);

        
    }

    //Test Route
    public function test() {
        
    }

}
