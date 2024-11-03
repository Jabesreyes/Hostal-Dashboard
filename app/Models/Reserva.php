<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $fechaActual = new DateTime();
        $fechaIngreso = $fechaActual->modify('first day of this month')->format('Y-m-d');
        $fechaRetiro = $fechaActual->modify('last day of this month')->format('Y-m-d');
        return Reserva::with(['clientes', 'estado_reservas'])->where(function ($query) use ($fechaIngreso, $fechaRetiro) {
            $query->whereBetween('fecha_ingreso', [$fechaIngreso, $fechaRetiro])
                ->orWhereBetween('fecha_retiro', [$fechaIngreso, $fechaRetiro])
                ->orWhere(function ($query) use ($fechaIngreso, $fechaRetiro) {
                    $query->where('fecha_ingreso', '<=', $fechaIngreso)
                        ->where('fecha_retiro', '>=', $fechaRetiro);
                });
        })->get();
    }
}
