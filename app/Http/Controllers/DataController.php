<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use App\Classes\RetaxMaster;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
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
use App\Imports\GaliciaImport;
use App\Imports\JubiladosImport;
use App\Imports\MacroImport;
use App\Imports\MovistarImport;
use App\Imports\ObrasSocialesImport;
use App\Imports\PersonalImport;

class DataController extends Controller {

    public function __construct() {
        $this->middleware("auth");
        $this->middleware("admin", ["only" => ["showAdminPanel"]]);
    }

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
        $inner = request("tablesToInner");

        return json_encode(self::searchData($query, $table, $limit, $inner));
    }

    public static function searchData($query, $table, $limit, $inner) {
        //Reviso en qué tabla se está buscando
        switch ($table) {
            case 1: $schema = "claros"; $prefix = "Claro"; break;
            case 2: $schema = "galicias"; $prefix = "Galicia"; break;
            case 3: $schema = "jubilados"; $prefix = "Jubilados"; break;
            case 4: $schema = "macros"; $prefix = "Macro"; break;
            case 5: $schema = "movistars"; $prefix = "Movistar"; break;
            case 6: $schema = "obras_sociales"; $prefix = "ObrasSociales"; break;
            case 7: $schema = "personals"; $prefix = "Personal"; break;
            default: $schema = null; break;
        }

        //Obtengo las columnas de esa tabla, y quito a la columna persona
        $columns = self::getColumns($schema, $prefix, false);

        //Obtengo las columnas de la tabla persona
        $columnsPersonas = Schema::getColumnListing("personas");
        unset($columnsPersonas[array_search("id", $columnsPersonas)]);
        unset($columnsPersonas[array_search("created_at", $columnsPersonas)]);
        unset($columnsPersonas[array_search("updated_at", $columnsPersonas)]);
        $columnsPersonas = array_values($columnsPersonas);

        //Junto ambas
        $columns = array_merge($columnsPersonas, $columns); // <- Columnas en las que quiero que busque (Array) porque lo recorremos para formar los where
        $columnsToSelect = implode("', '", $columns); // <- Columnas que quiero que me seleccione (string separado por comas)
        
        //Armo la consulta de Eloquent por medio de un string
        
        // Si el usuario decidió unirlas
        $innerTables = "";
        if (!empty($inner)) {
            $userInner = self::innerTables($table, $columnsToSelect, $inner);
            $innerTables = $userInner["innerTables"];
            $columnsToSelect = $userInner["columns"];
        }
        // ->Si el usuario decidió unirlas

        // Armo la variable que contendrá los headers
        $headers = explode("', '", $columnsToSelect);
        for ($i=0; $i < count($headers); $i++) { 
            $explode = explode(" AS ", $headers[$i]);
            $headers[$i] = array_pop($explode);
            $explode  = explode(".", $headers[$i]);
            $headers[$i] = array_pop($explode);
        }
        // -> Armo la variable que contendrá los headers

        //Aquí inicia la consulta
        $eloquentQuery = '$results = '."App\\Personas::select('$columnsToSelect')->leftjoin('$schema', 'personas.id', '=', '$schema.persona')$innerTables";

        for ($i=0; $i < count($columns); $i++) {
            if ($i != 0)
                $eloquentQuery .= "\n\t\t->orWhere('$columns[$i]', 'like', '%$query%')";
            else
                $eloquentQuery .= "\n\t\t->where('$columns[$i]', 'like', '%$query%')";
        }

        $putLimit = $limit == null ? "" : "limit($limit)->";
        $eloquentQuery .= "->". $putLimit."get();";

        //Evaluo la consulta como codigo PHP
        eval($eloquentQuery);

        //A partir de aquí ya tengo los datos y preparo la respuesta

        //Respuesta para el sistema
        $response["status"] = "true";
        $response["headers"] = $headers;        
        $response["rows"] = $results;
        return $response;

        //respuesta para test
        /* return [
            "results" => $results->toArray(),
            "query" => $eloquentQuery
        ]; */
    }

    //Este metodo junta las tablas
    public static function innerTables($table, $columnsToSelect, $inner) {
        $innerTables = "";
        $columnsToSelect = explode("', '", $columnsToSelect);
        if ($table != 1 && in_array(1, $inner)) {
            $innerTables .= "->leftjoin('claros', 'personas.id', '=', 'claros.persona')";
            $columnsToSelect = array_merge($columnsToSelect, self::getColumns("claros", "Claro"));
        }
        if ($table != 2 && in_array(2, $inner)) {
            $innerTables .= "->leftjoin('galicias', 'personas.id', '=', 'galicias.persona')";
            $columnsToSelect = array_merge($columnsToSelect, self::getColumns("galicias", "Galicia"));
        }
        if ($table != 3 && in_array(3, $inner)) {
            $innerTables .= "->leftjoin('jubilados', 'personas.id', '=', 'jubilados.persona')";
            $columnsToSelect = array_merge($columnsToSelect, self::getColumns("jubilados", "Jubilados"));
        }
        if ($table != 4 && in_array(4, $inner)) {
            $innerTables .= "->leftjoin('macros', 'personas.id', '=', 'macros.persona')";
            $columnsToSelect = array_merge($columnsToSelect, self::getColumns("macros", "Macro"));
        }
        if ($table != 5 && in_array(5, $inner)) {
            $innerTables .= "->leftjoin('movistars', 'personas.id', '=', 'movistars.persona')";
            $columnsToSelect = array_merge($columnsToSelect, self::getColumns("movistars", "Movistar"));
        }
        if ($table != 6 && in_array(6, $inner)) {
            $innerTables .= "->leftjoin('obras_sociales', 'personas.id', '=', 'obras_sociales.persona')";
            $columnsToSelect = array_merge($columnsToSelect, self::getColumns("obras_sociales", "ObrasSociales"));
        }
        if ($table != 7 && in_array(7, $inner)) {
            $innerTables .= "->leftjoin('personals', 'personas.id', '=', 'personals.persona')";
            $columnsToSelect = array_merge($columnsToSelect, self::getColumns("personals", "Personal"));
        }

        return [
            "innerTables" => $innerTables,
            "columns" => implode("', '", $columnsToSelect)
        ];
    }

    //Este método obtiene las columnas de una tabla y retorna la lista para el select
    public static function getColumns($tableName, $prefix, $putAs = true) {
        $columns = Schema::getColumnListing($tableName);
        unset($columns[array_search("id", $columns)]);
        unset($columns[array_search("persona", $columns)]);
        unset($columns[array_search("created_at", $columns)]);
        unset($columns[array_search("updated_at", $columns)]);
        $columns = array_values($columns);
        
        //Sobreescribo los nombres de las columnas para agregar un AS para evitar columnas duplicadas en las tablas al hacer el inner join

        
        for ($i=0; $i < count($columns); $i++) {
            $as = $putAs ? " AS $prefix" . ucfirst($columns[$i]) : "";
            $columns[$i] = "$tableName." . $columns[$i] . $as;
        }

        return $columns;
        
    }

    //Exporta los datos de una query
    //Exporta la lista de productos
    public function export() {
        $query = request("query");
        $table = request("table");
        $limit = request("limit");
        $inner = request("tablesToInner");

        if($query == null) return back()->withErrors(["notQuery" => "No se encontró ningún parámetro de búsqueda"]);
        $inner = ($inner == null) ? "" : explode(",", $inner);
        if($table == null) $table = "";
        if($limit == null) $limit = "";

        $export = self::searchData($query, $table, $limit, $inner);
        
        $fileName = "Export.xlsx";
        Excel::store(new DataExport($export), $fileName);
        return $fileName;
    }

    public function download($fileName) {
        return response()->download(storage_path("/app/$fileName"));
    }

    public static function getColumnLetter($num) {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if ($num2 > 0) {
            return self::getColumnLetter($num2) . $letter;
        } else {
            return $letter;
        }
    }

    //Test Route
    public function test() {
        /* $query = "25585211";
        $table = 1;
        $limit = null;
        $inner = [];

        $data = self::searchData($query, $table, $limit, $inner)["rows"]; */

        dd(self::getColumnLetter(40));

        dd($data);

    }

}
