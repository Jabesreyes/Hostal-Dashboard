<?php

use App\Http\Controllers\CheckInController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\EstadoReservaController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\ReservaController;
use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Estado_reserva;
use App\Models\Habitacion;
use App\Models\Pais;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/pais',[PaisController::class,'index'])->name('pais');
Route::post('/pais',[PaisController::class,'store']);
Route::delete('/pais/{id}', [PaisController::class ,'destroy']);
Route::get('/pais/buscar', [PaisController::class,'buscar'])->name('pais.buscar');
Route::patch('/pais/{id}/edit', [PaisController::class ,'update']);
Route::get('pais/{id}/edit', [PaisController::class ,'edit'])->name(('pais.edit'));

Route::get('/estado',[EstadoController::class,'index'])->name('estado');
Route::post('/estado',[EstadoController::class,'store']);
Route::delete('/estado/{id}', [EstadoController::class ,'destroy']);
Route::patch('/estado/{id}/edit', [EstadoController::class ,'update']);
Route::get('estado/{id}/edit', [EstadoController::class ,'edit'])->name(('estado.edit'));
//rutas para las habitaciones
Route::get('/habitacion',[HabitacionController::class,'index'])->name('habitacion');
Route::post('/habitacion',[HabitacionController::class,'store']);
Route::delete('/habitacion/{id}', [HabitacionController::class ,'destroy']);
Route::patch('/habitacion/{id}/edit', [HabitacionController::class ,'update']);
Route::get('habitacion/{id}/edit', [HabitacionController::class ,'edit'])->name(('habitacion.edit'));
Route::get('habitacion/buscar/{id}/', [HabitacionController::class ,'buscarPorId'])->name(('habitacion.buscar'));
//rutas para los metodos de pagos
Route::get('/metodo',[MetodoPagoController::class,'index'])->name('metodo');
Route::post('/metodo',[MetodoPagoController::class,'store']);
Route::delete('/metodo/{id}', [MetodoPagoController::class ,'destroy']);
Route::patch('/metodo/{id}/edit', [MetodoPagoController::class ,'update']);
Route::get('metodo/{id}/edit', [MetodoPagoController::class ,'edit'])->name(('metodo.edit'));
//rutas para las plataformas
Route::get('/plataforma',[PlataformaController::class,'index'])->name('plataforma');
Route::post('/plataforma',[PlataformaController::class,'store']);
Route::delete('/plataforma/{id}', [PlataformaController::class ,'destroy']);
Route::patch('/plataforma/{id}/edit', [PlataformaController::class ,'update']);
Route::get('plataforma/{id}/edit', [PlataformaController::class ,'edit'])->name(('plataforma.edit'));
//rutas para cliente
Route::get('/cliente',[ClienteController::class,'index'])->name('cliente');
Route::post('/cliente',[ClienteController::class,'store']);
Route::delete('/cliente/{id}', [ClienteController::class ,'destroy']);
Route::patch('/cliente/{id}/edit', [ClienteController::class ,'update']);
Route::get('cliente/{id}/edit', [ClienteController::class ,'edit'])->name(('cliente.edit'));
Route::get('/cliente/buscar', [ClienteController::class,'buscar'])->name('cliente.buscar');

Route::get('/reserva',[ReservaController::class,'index'])->name('reserva');
Route::get('/reserva/calendario',[ReservaController::class,'obtenerReservas'])->name('reserva');
Route::post('/reserva/validar',[ReservaController::class,'verificarReserva']);
Route::post('/reserva',[ReservaController::class,'store']);
Route::patch('/reserva/{id}',[ReservaController::class,'update']);

Route::get('/checkin',[CheckInController::class,'index'])->name('checkin');

//url para estados de las reservas
Route::get('/estadoreserva',[EstadoReservaController::class,'index']);
Route::post('/estadoreserva',[EstadoReservaController::class,'store']);
Route::delete('/estadoreserva/{id}', [EstadoReservaController::class ,'destroy']);
Route::patch('/estadoreserva/{id}/edit', [EstadoReservaController::class ,'update']);
Route::get('/estadoreserva/{id}/edit', [EstadoReservaController::class ,'edit']);