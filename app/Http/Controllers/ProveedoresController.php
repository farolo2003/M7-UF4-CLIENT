<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProveedoresController extends Controller
{
    public function index()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(env('RUTA').'/proveedores');

        if ($response->successful()) {
            $proveedores = $response->json(); 
            return view('proveedores', compact('proveedores'));
        } else {
            return back()->with('error', 'Error al obtener los detalles del proveedor. Por favor, inténtelo de nuevo.');
        }
    }

    public function store(Request $request)
    {
        $token = session('token');
        $data = $request->validate([
            "nombre" => "string|required",
            "telefono" => "string|required",
            "direccion" => "string|required",
            "ciudad" => "string|required",
            "pais" => "string|required",
            "cp" => "string|required",
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(env('RUTA').'/proveedores', $data);

        if ($response->successful()) {
            return redirect()->route('proveedores.index');
        } else {
            return back()->with('error', 'Error al crear el proveedor. Por favor, inténtelo de nuevo.');
        }
    }
    public function update(Request $request, $id)
    {
        $token = session('token');
        $data = $request->validate([
            "nombre" => "string|required",
            "telefono" => "string|required",
            "direccion" => "string|required",
            "ciudad" => "string|required",
            "pais" => "string|required",
            "cp" => "string|required",
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put(env('RUTA')."/proveedores/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('proveedores.index');
        } else {
            return back()->with('error', 'Error al actualizar el proveedor. Por favor, inténtelo de nuevo.');
        }
    }

    public function destroy($id)
    {
        $token = session('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete(env('RUTA')."/proveedores/{$id}");

        if ($response->successful()) {
            return redirect()->route('proveedores.index');
        } else {
            return back()->with('error', 'Error al eliminar el proveedor. Por favor, inténtelo de nuevo.');
        }
    }
}
