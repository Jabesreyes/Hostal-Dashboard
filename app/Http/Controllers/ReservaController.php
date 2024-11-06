<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Estado_reserva;
use App\Models\Habitacion;
use App\Models\Metodo_pago;
use App\Models\Plataforma;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes=Cliente::all();
        $plataformas=Plataforma::all();
        $habitacions=Habitacion::all();
        $metodos=Metodo_pago::all();
        $estados_reserva=Estado_reserva::all();
        return view('reserva.index',compact(['clientes','habitacions','plataformas','metodos','estados_reserva']));
    }
    public function verificarReserva(Request $request)
    {
        $habitacionId = $request->input('habitacions_id');
        $fechaIngreso = $request->input('fecha_ingreso');
        $fechaRetiro = $request->input('fecha_retiro');
        if (Reserva::existeReserva($habitacionId, $fechaIngreso,$fechaRetiro)) {
            return response()->json(['error' => 'La habitación ya está reservada en esa fecha']);
        }
        else
        {
            return response()->json(['mensaje'=>'Habitacion disponible '. $fechaIngreso.''.$habitacionId]);
        }
        
    }
    //retorna los datos de las reservas al calendario
    public function obtenerReservas()
    {
        // Obtener las reservas con la información de la habitación asociada
        $reservas = Reserva::with(['habitacions','clientes'])->get();

        // Formatear los datos para enviarlos al frontend
        $eventos = $reservas->map(function($reserva) {
            return [
                'locale'=>'es',
                'start' => $reserva->fecha_ingreso,
                'end' => $reserva->fecha_retiro,
                'backgroundColor' => $reserva->habitacions->color,  // Asumiendo que el campo color está en habitacion
                'title' =>$reserva->clientes->nombre,
                'habitacion' => 'Habitacion: ' . $reserva->habitacions->numero.' ' . $reserva->habitacions->nombre
            ];
        });
        // Retornar los eventos en formato JSON
        return response()->json($eventos);
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
        Reserva::insert($datos);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        try {
            $dato = request()->except(['_token', '_method']);
            // Actualiza los datos de la categoría con los datos de la solicitud
            Reserva::where('id', '=', $id)->update($dato);
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
