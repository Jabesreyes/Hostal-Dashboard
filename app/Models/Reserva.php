<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Reserva extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function habitacions()
    {
        return $this->belongsTo(Habitacion::class);
    }
    public function clientes()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function estado_reservas()
    {
        return $this->belongsTo(Estado_reserva::class);
    }
    public static function existeReserva($habitacionId, $fechaIngreso, $fechaRetiro)
    {
        return Reserva::where('habitacions_id', $habitacionId)
            ->where('congelar', '=', true)
            ->where(function ($query) use ($fechaIngreso, $fechaRetiro) {
                $query->whereBetween('fecha_ingreso', [$fechaIngreso, $fechaRetiro])
                    ->orWhereBetween('fecha_retiro', [$fechaIngreso, $fechaRetiro])
                    ->orWhere(function ($query) use ($fechaIngreso, $fechaRetiro) {
                        $query->where('fecha_ingreso', '<=', $fechaIngreso)
                            ->where('fecha_retiro', '>=', $fechaRetiro);
                    });
            })
            ->exists();
    }
    //reservas del mes
    public static function reservasDelMes()
    {
        $fechaHoy = Carbon::today('America/El_Salvador')->toDateString();
        return Reserva::with(['clientes', 'estado_reservas', 'habitacions'])
            ->where('estado_reservas_id', '!=', 1)->whereDate('fecha_ingreso', $fechaHoy)->get();
    }
    //reservas del mes
    public static function reservasDeSemana($fechaInicio, $fechaFin)
    {
        $fechaInicio = Carbon::parse($fechaInicio)->startOfDay(); // Comienza a las 00:00:00
        $fechaFin = Carbon::parse($fechaFin)->endOfDay(); // Termina a las 23:59:59
        return Reserva::with(['clientes', 'estado_reservas', 'habitacions'])
            ->where('estado_reservas_id', '!=', 2)
            ->where('estado_reservas_id', '!=', 3)
            ->whereBetween('fecha_ingreso', [$fechaInicio, $fechaFin])
            ->get();
    }
    public static function reservasDeSemanaOut($fechaInicio, $fechaFin)
    {
        $fechaInicio = Carbon::parse($fechaInicio)->startOfDay(); // Comienza a las 00:00:00
        $fechaFin = Carbon::parse($fechaFin)->endOfDay(); // Termina a las 23:59:59
        return Reserva::with(['clientes', 'estado_reservas', 'habitacions'])
            ->where('estado_reservas_id', '=', 2)
            ->where('estado_reservas_id', '!=', 1)
            ->whereBetween('fecha_ingreso', [$fechaInicio, $fechaFin])
            ->get();
    }
}
