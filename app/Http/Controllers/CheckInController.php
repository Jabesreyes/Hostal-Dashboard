<?php

namespace App\Http\Controllers;

use App\Models\Estado_reserva;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckInController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estadoreservas = Estado_reserva::all();
        return view('checkin.index', compact('estadoreservas'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function filtrar(Request $request)
    {
        $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->fechaInicio)->format('Y-m-d');
        $fechaFin = Carbon::createFromFormat('d/m/Y', $request->fechaFin)->format('Y-m-d');
        $reservas = Reserva::reservasDeSemana($fechaInicio,$fechaFin);
        return response()->json(['reservas' => $reservas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
