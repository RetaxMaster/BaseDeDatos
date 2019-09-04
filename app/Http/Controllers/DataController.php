<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller {

    //Muestra el panel de administrador
    public function showAdminPanel() {
        return view("admin");
    }

    //Muestra la sección de búsquedas
    public function showSearch() {
        return view("search");        
    }

}
