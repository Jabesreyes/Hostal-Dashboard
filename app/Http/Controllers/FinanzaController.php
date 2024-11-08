<?php

namespace App\Http\Controllers;

use App\Models\Finanza;
use App\Models\Plataforma;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanzaController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $primerDia = Carbon::now()->startOfYear();
        $ultimoDia = Carbon::now()->endOfYear();
        $totalGeneral = Finanza::join('reservas', 'finanzas.reservas_id', '=', 'reservas.id')
            ->join('clientes', 'clientes.id', '=', 'reservas.clientes_id')
            ->join('plataformas', 'plataformas.id', '=', 'reservas.plataformas_id')
            ->select('finanzas.*', 'reservas.*', 'clientes.*', 'plataformas.*')
            ->whereBetween('fecha_retiro', [$primerDia, $ultimoDia])
            ->sum('reservas.total_pagado');
        $primerDiaMes = Carbon::now()->startOfMonth();
        $ultimoDiaMes = Carbon::now()->endOfMonth();
        $totalPrecio = Finanza::join('reservas', 'finanzas.reservas_id', '=', 'reservas.id')
            ->join('clientes', 'clientes.id', '=', 'reservas.clientes_id')
            ->join('plataformas', 'plataformas.id', '=', 'reservas.plataformas_id')
            ->select('finanzas.*', 'reservas.*', 'clientes.*', 'plataformas.*')
            ->whereBetween('fecha_retiro', [$primerDiaMes, $ultimoDiaMes])
            ->sum('reservas.total_pagado');

        $datos = Finanza::join('reservas', 'finanzas.reservas_id', '=', 'reservas.id')
            ->join('clientes', 'clientes.id', '=', 'reservas.clientes_id')
            ->join('plataformas', 'plataformas.id', '=', 'reservas.plataformas_id')
            ->select('finanzas.*', 'reservas.*', 'clientes.*', 'plataformas.*')
            ->get();
        $plataformas = Plataforma::all();
        return view('finanza.index', compact('datos', 'plataformas', 'totalPrecio','totalGeneral'));
    }
    public function filtrar(Request $request)
    {
        $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->fechaInicio)->format('Y-m-d');
        $fechaFin = Carbon::createFromFormat('d/m/Y', $request->fechaFin)->format('Y-m-d');
        $datos = Finanza::filtrarPlataformaFecha($fechaInicio, $fechaFin, $request->input('plataformaId'));
        return response()->json(['finanzas' => $datos]);
    }
}
