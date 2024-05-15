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
        ])->get(env('RUTA').'/products');

        if ($response->successful()) {
            $productos = $response->json(); 
            return view('productos', compact('productos'));
        } else {
            return back()->with('error', 'Error al obtener los detalles del producto. Por favor, inténtelo de nuevo.');
        }
    }

    public function store(Request $request)
    {
        $token = session('token');
        $data = $request->validate([
            "nombre" => "string|required",
            "descripcion" => "string|required",
            "precio" => "numeric|required",
            "stock" => "numeric|required",
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(env('RUTA').'/products', $data);

        if ($response->successful()) {
            return redirect()->route('productos.index');
        } else {
            return back()->with('error', 'Error al crear el producto. Por favor, inténtelo de nuevo.');
        }
    }
    public function update(Request $request, $id)
    {
        $token = session('token');
        $data = $request->validate([
            "nombre" => "string|required",
            "descripcion" => "string|required",
            "precio" => "numeric|required",
            "stock" => "numeric|required",
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put(env('RUTA')."/products/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('productos.index');
        } else {
            return back()->with('error', 'Error al actualizar el producto. Por favor, inténtelo de nuevo.');
        }
    }

    public function destroy($id)
    {
        $token = session('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete(env('RUTA')."/products/{$id}");

        if ($response->successful()) {
            return redirect()->route('productos.index');
        } else {
            return back()->with('error', 'Error al eliminar el producto. Por favor, inténtelo de nuevo.');
        }
    }
}
