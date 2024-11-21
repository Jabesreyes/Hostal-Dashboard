<?php

namespace App\Http\Controllers;

use App\Models\Finanza;
use App\Models\Habitacion;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $habitacionesLibres = DB::table('habitacions')
            ->where('estados_id', 1)
            ->count();
        $habitacionesOcupadas = DB::table('habitacions')
            ->where('estados_id', 2)
            ->count();
        $habitacionesMantenimiento = DB::table('habitacions')
            ->where('estados_id', 3)
            ->count();
        $habitaciones = Habitacion::count();
        $ultimasReservas = Reserva::select()
            ->join('clientes', 'reservas.clientes_id', '=', 'clientes.id')
            ->orderBy('fecha_reserva', 'desc')
            ->limit(5)
            ->get();
        return view('/home', compact('habitaciones', 'habitacionesLibres', 'habitacionesOcupadas', 'habitacionesMantenimiento', 'ultimasReservas'));
    }
    public function graficoCircular()
    {
        $primerDiaMes = Carbon::now()->startOfMonth();
        $ultimoDiaMes = Carbon::now()->endOfMonth();
        $result = Reserva::select(
            DB::raw('COUNT(reservas.plataformas_id) AS total_reservas'),
            'reservas.plataformas_id',
            'plataformas.plataforma'
        )
            ->leftJoin('plataformas', 'plataformas.id', '=', 'reservas.plataformas_id')
            ->whereBetween('fecha_ingreso', [$primerDiaMes, $ultimoDiaMes])
            ->groupBy('reservas.plataformas_id', 'plataformas.plataforma')
            ->get();
        return response()->json($result);
    }
    public function graficoBarra()
    {
        $primerDiaMes = Carbon::now()->startOfMonth();
        $ultimoDiaMes = Carbon::now()->endOfMonth();
        $result = Finanza::join('reservas', 'finanzas.reservas_id', '=', 'reservas.id')
            ->join('clientes', 'clientes.id', '=', 'reservas.clientes_id')
            ->join('plataformas', 'plataformas.id', '=', 'reservas.plataformas_id')
            ->selectRaw('SUM(reservas.total_pagado) AS totalPrecio, plataformas.plataforma')
            ->whereBetween('fecha_retiro', [$primerDiaMes, $ultimoDiaMes])
            ->groupBy('plataformas.id')
            ->get();
        return response()->json($result);
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
