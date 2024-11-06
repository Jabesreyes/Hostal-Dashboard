<?php

namespace App\Http\Controllers;

use App\Models\Metodo_pago;
use Illuminate\Http\Request;

class MetodoPagoController
{
    public function index()
    {
        $data['metodos'] = Metodo_pago::all();
        return view('metodo.index', $data);
    }
    public function store(Request $request)
    {
        $datos = request()->except(['_token', '_method']);
        Metodo_pago::insert($datos);
    }
    public function edit($id)
    {
        $metodo = Metodo_pago::findOrFail($id);
        return view('metodo.edit', compact('metodo'));
    }
    public function update(Request $request, $id)
    {
        try {
            $dato = request()->except(['_token', '_method']);
            // Actualiza los datos de la categoría con los datos de la solicitud
            Metodo_pago::where('id', '=', $id)->update($dato);
        } catch (\Exception $e) {
            // Otros tipos de excepciones
            return response()->json(['error' => 'Error interno del servidor' . $e], 500);
        }
    }
    public function destroy($id)
    {
        $cat = Metodo_pago::destroy($id);
    }
}
