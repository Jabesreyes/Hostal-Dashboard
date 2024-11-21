@extends('adminlte::page')

@section('title', 'Restablecer')
@php
@endphp
@section('content_header')
@stop

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Cambiar Contraseña</h4>
                </div>
                <div class="card-body">
                    <!-- Mensajes de validación -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('user-password.update') }}">
                        @csrf
                        @method('PUT')
                        <!-- Contraseña actual -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" name="current_password" id="current_password"
                                class="form-control" required autocomplete="current-password">
                        </div>

                        <!-- Nueva contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" name="password" id="password"
                                class="form-control" required autocomplete="new-password">
                        </div>

                        <!-- Confirmar nueva contraseña -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required autocomplete="new-password">
                        </div>

                        <!-- Botón para enviar -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">Actualizar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop
@section('js')
@vite('resources/js/app.js')
@stop