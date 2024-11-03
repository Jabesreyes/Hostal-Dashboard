@extends('adminlte::page')

@section('title', 'Habitacion | Editar')
@php
@endphp
@section('content_header')
@stop

@section('content')
<form>
    @csrf
    @method('patch')
    <div class="modal-body">
        <div class="col">
            <label for="numero">Numero de la Habitacion</label>
            <input type="number" value="{{$habitacion->numero}}" class="form-control" id="numero" name="numero" placeholder="Numero de la habitacion" />
            <label for="nombre">Nombre de la Habitacion</label>
            <input type="text" value="{{$habitacion->nombre}}" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre de la habitacion" />
        </div>
        <div class="col">
            <label for="capacidad">Capacidad de la Habitacion</label>
            <input type="number" value="{{$habitacion->capacidad}}" class="form-control" id="capacidad" name="capacidad" placeholder="Capacidad de la habitacion" />
            <label for="descripcion">Descripcion de la Habitacion</label>
            <input type="text" value="{{$habitacion->descripcion}}" class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion de la habitacion" />

        </div>
        <div class="col">
            <label for="estado">Estado de la habitacion</label>
            <select class="form-control" name="estado" id="estado">
                @foreach ($estado as $estado)
                @if($estado->id==$habitacion->estados_id)
                <option selected value="{{ $estado->id}}">{{ $estado->estado }}</option>
                @else
                <option value="{{ $estado->id}}">{{ $estado->estado }}</option>
                @endif
                @endforeach
            </select>
            <label for="precio">Precio de la Habitacion 24 H</label>
            <input type="text" value="{{$habitacion->precio}}" class="form-control" id="precio" name="precio" placeholder="precio de la habitacion" />
        </div>
        <div class="col">
            <label for="precio_promocion">Precio de promocion</label>
            <input type="text" value="{{$habitacion->precio_promocion}}" class="form-control" id="precio_promocion" name="precio_promocion" placeholder="precio promocional de la habitacion" />
            <label for="color">Color para la reserva</label>
            <input class="form-control" type="color" id="color" value="{{$habitacion->color}}" value="#000000">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="actualizar('{{$habitacion->id}}')" class="btn btn-primary">actualizar</button>
    </div>
</form>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop

@section('js')
@vite('resources/js/app.js')
<script>
    function actualizar(id) {
        var estado = document.getElementById('estado').value;
        var nombre = document.getElementById('nombre').value;
        var precio = document.getElementById('precio').value;
        var precio_promocion = document.getElementById('precio_promocion').value;
        var numero = document.getElementById('numero').value;
        var capacidad = document.getElementById('capacidad').value;
        var descripcion = document.getElementById('descripcion').value;
        var color = document.getElementById('color').value;
        const Estado = {
            numero:numero,
            nombre:nombre,
            capacidad:capacidad,
            descripcion:descripcion,
            estados_id: estado,
            precio:precio,
            precio_promocion:precio_promocion,
            color:color,
            id:id
        }
        console.log(Estado)
        var urlActual = window.location.href;
        var nuevaUrl = urlActual.replace('/' + id + '/edit', '');
        console.log('nueva url ' + nuevaUrl + '/' + id)
        axios.patch(urlActual, Estado)
            .then(response => {
                console.log(response)
                Swal.fire({
                    title: "Actualizado",
                    text: "Registro Actualizado",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    axios.get(nuevaUrl).then(function(response) {
                            window.location.href = nuevaUrl;
                        })
                        .catch(function(error) {});
                });
            })
            .catch(function(error) {
                console.error(error.request.response)
                Swal.fire({
                    title: "Error",
                    text: "Registro no actualizado " + error,
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    window.location.href = nuevaUrl;
                });
            });
    }
</script>
@stop