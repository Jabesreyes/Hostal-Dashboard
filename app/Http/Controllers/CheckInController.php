<?php

namespace App\Http\Controllers;

use App\Models\Estado_reserva;
use App\Models\Reserva;
use Illuminate\Http\Request;

class CheckInController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas['estadoreservas']=Estado_reserva::all();
        $data['reservas'] = Reserva::reservasDelMes();
        return view('checkin.index', $data,$datas);
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