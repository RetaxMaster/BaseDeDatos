<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{

    protected function register()
    {   

        //Validación de datos
        $credentials = $this->validate(request(), [
            "username" => "required|string|unique:users",
            "email" => "required|string",
            "MakeAdmin" => "boolean",
            "password" => "required|string"
        ]);

        User::create([
            'username' => $credentials['username'],
            'email' => $credentials['email'],
            'rol' => isset($credentials['MakeAdmin']) ? 1 : 0,
            'password' => bcrypt($credentials['password']),
        ]);

        return back()->with("registered", "Usuario registrado con éxito");
    }
}
