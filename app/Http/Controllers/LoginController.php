<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function login(Request $request){
   
        $data = $request->validate([
            "email" => "string|required",
            "password" => "string|required"
        ]);
        $response = Http::post('http://localhost:8000/api/login', $data);

        $responseData = $response->json();

        if ($response->successful() && isset($responseData['token'])) {
            session(['token' => $responseData['token']]);
            return Redirect::route('main.index');

            
        } else {
            return redirect()->back()->with('error', 'Credenciales incorrectas');
        }
    }
}
