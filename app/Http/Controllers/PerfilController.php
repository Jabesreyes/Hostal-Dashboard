<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PerfilController
{
    public function edit()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        return view('perfil.edit', compact('user')); // Pasar los datos del usuario a la vista
    }
}
