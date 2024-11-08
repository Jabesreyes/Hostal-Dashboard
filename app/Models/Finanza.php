<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finanza extends Model
{
    public $timestamps = false;
    use HasFactory;
    
    public static function filtrarPlataformaFecha($fechaInicio,$fechaFin,$plataformaId)
    {
        return Finanza::join('reservas', 'finanzas.reservas_id', '=', 'reservas.id')
            ->join('clientes', 'clientes.id', '=', 'reservas.clientes_id')
            ->join('plataformas', 'plataformas.id', '=', 'reservas.plataformas_id')
            ->select('finanzas.*', 'reservas.*', 'clientes.*', 'plataformas.*')
            ->whereBetween('fecha_retiro', [$fechaInicio, $fechaFin])
            ->where('plataformas_id','=',$plataformaId)
            ->get();
    }
}
