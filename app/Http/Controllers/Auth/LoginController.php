<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller {

    public function __construct() {
        $this->middleware("guest", ["only" => "showLoginForm"]);        
    }

    public function showLoginForm() {
        return view("auth/login");
    }

    public function login() {
        
        //Validación de datos
        $credentials = $this->validate(request(), [
            "username" => "required|string",
            "password" => "required|string"
        ]);

        if(Auth::attempt($credentials)) {
            return redirect()->route("home");
        }

        return back()->withErrors(["login_failed" => "Usuario o contraseña incorrectos."]);

    }

    public function logout() {
        Auth::logout();
        return redirect()->route("login");
    }

}
