@extends('adminlte::page')

@section('title', 'Pais | Editar')
@php
@endphp
@section('content_header')
@stop

@section('content')
<form>
    @csrf
    @method('patch')
    <div class="modal-body">
        <div class="form-group">
            <label for="nombre">Nombre del pais</label>
            <input type="text" value="{{$pais->nombre}}" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del pais" />
        </div>
        <div class="form-group">
            <label for="siglas">Siglas del pais</label>
            <input type="text" value="{{$pais->siglas}}" class="form-control" id="siglas" name="siglas" placeholder="Siglas del pais ejemplo (GT , SV ,HN)" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="actualizar('{{$pais->id}}')" class="btn btn-primary">actualizar</button>
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
        var nombre = document.getElementsByName('nombre')[0].value;
        var siglas = document.getElementsByName('siglas')[0].value;

        const Pais = {
            nombre: nombre,
            siglas: siglas,
            id: id
        }
        console.log(Pais)
        var urlActual = window.location.href;
        var nuevaUrl = urlActual.replace('/' + id + '/edit', '');
        console.log('nueva url ' + nuevaUrl + '/' + id)
        axios.patch(urlActual, Pais)
            .then(response=> {
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