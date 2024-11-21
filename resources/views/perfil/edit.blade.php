@extends('adminlte::page')

@section('title', 'Perfil')
@php
@endphp
@section('content_header')
@stop

@section('content')
<div class="container">
    <h3>Editar Perfil</h3>

    <form method="POST" action="{{ route('user-profile-information.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop
@section('js')
@vite('resources/js/app.js')
@stop