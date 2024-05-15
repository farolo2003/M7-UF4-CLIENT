<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class RegisterController extends Controller
{
    public function index(){
        return view('register');
    }

    public function store(Request $request){
        $data = $request->validate([
            "name" => "string|required",
            "email" => "string|required",
            "password" => "string|required"
        ]);
        $response = Http::post(env('RUTA').'/register', $data);
        return Redirect::route('login.index');
    }
}
