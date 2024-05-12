<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductosController extends Controller
{
    public function index()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://localhost:8000/api/products');

        if ($response->successful()) {
            $productos = $response->json(); 
            return view('productos', compact('productos'));
        } else {
            return back()->with('error', 'Error al obtener los detalles del producto. Por favor, inténtelo de nuevo.');
        }

    }

    public function store(Request $request)
    {
        // Obtener el token de sesión guardado

        $token = session('token');

        // Validar los datos del formulario
        $data = $request->validate([
            "nombre" => "string|required",
            "descripcion" => "string|required",
            "precio" => "numeric|required",
            "stock" => "numeric|required",
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://localhost:8000/api/products', $data);

        if ($response->successful()) {
            return redirect()->route('productos.index');
        } else {
            return back()->with('error', 'Error al crear el producto. Por favor, inténtelo de nuevo.');
        }
    }






}