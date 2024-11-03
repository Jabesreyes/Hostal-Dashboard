<?php

namespace App\Http\Controllers;

use App\Models\Metodo_pago;
use Illuminate\Http\Request;

class MetodoPagoController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['metodos'] = Metodo_pago::all();
        return view('metodo.index', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = request()->except(['_token', '_method']);
        Metodo_pago::insert($datos);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $metodo = Metodo_pago::findOrFail($id);
        return view('metodo.edit', compact('metodo'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cat = Metodo_pago::destroy($id);
    }
}
