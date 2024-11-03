<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PaisController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['paises']=Pais::paginate(5);
        return view('pais.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function buscar(Request $request)
    {
        $texto = $request->input('buscar');
        $resultados['paises'] = Pais::buscar($texto);
        return view('pais.index', $resultados);
    }
     
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos=request()->except(['_token','_method']);
        Pais::insert($datos);
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
        $pais = Pais::findOrFail($id);
        return view('pais.edit', compact('pais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        try {
            $dato = request()->except(['_token','_method']);
            // Actualiza los datos de la categoría con los datos de la solicitud
            Pais::where('id','=',$id)->update($dato);
        } catch (\Exception $e) {
            // Otros tipos de excepciones
            return response()->json(['error' => 'Error interno del servidor'.$e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cat = Pais::destroy($id);
    }
}
