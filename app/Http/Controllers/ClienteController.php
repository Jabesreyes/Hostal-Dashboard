<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pais;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClienteController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = $request->input('buscar');
        $pais['paises'] = Pais::all();

        if (!$texto) {
            $clientes = Cliente::with('pais')->paginate(5);
            $clientes->appends(['buscar' => $texto]);
            return view('cliente.index', compact('clientes'), $pais);
        } else {
            $resultados['clientes'] = Cliente::buscar($texto);
            return view('cliente.index', $resultados, $pais);
        }
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
        $datos = request()->except(['_token', '_method', 'page']);
        // $datos['created_at']=(Carbon::now());
        Cliente::insert($datos);
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
        $paises = Pais::all();
        $cliente = Cliente::findOrFail($id);
        return view('cliente.edit', compact('cliente', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $dato = request()->except(['_token', '_method']);
            // Actualiza los datos de la categoría con los datos de la solicitud
            Cliente::where('id', '=', $id)->update($dato);
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
        Cliente::destroy($id);
    }
}
