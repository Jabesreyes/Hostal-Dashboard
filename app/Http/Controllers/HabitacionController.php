<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados['estados'] = Estado::all();
        $data['habitaciones'] = Habitacion::with('estados')->get();
        return view('habitacion.index', $data, $estados);
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
        Habitacion::insert($datos);
    }

    /**
     * Display the specified resource.
     */
    public function buscarPorId($id)
    {
        $habitacion = Habitacion::find($id);
        if ($habitacion) {
            // Retorna la habitación si es encontrada
            return response()->json($habitacion);
        } else {
            // Retorna un error si la habitación no existe
            return response()->json(['message' => 'Habitación no encontrada'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $estado = Estado::all();
        $habitacion = Habitacion::findOrFail($id);
        return view('habitacion.edit', compact('habitacion', 'estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $dato = request()->except(['_token', '_method']);
            // Actualiza los datos de la categoría con los datos de la solicitud
            Habitacion::where('id', '=', $id)->update($dato);
        } catch (\Exception $e) {
            // Otros tipos de excepciones
            return response()->json(['error' => 'Error interno del servidor' . $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}