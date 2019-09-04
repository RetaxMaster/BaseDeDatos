<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller {

    public function showAdminPanel() {
        return view("admin");
    }

}
