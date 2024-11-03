@extends('adminlte::page')

@section('title', 'Estado | Editar')
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
            <label for="nombre">Estado</label>
            <input type="text" value="{{$estado->estado}}" class="form-control" id="estado" name="estado" placeholder="Ingrese el posible estado de la habtacion" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="actualizar('{{$estado->id}}')" class="btn btn-primary">actualizar</button>
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
        var estado = document.getElementsByName('estado')[0].value;

        const Estado = {
            estado: estado,
            id: id
        }
        console.log(Estado)
        var urlActual = window.location.href;
        var nuevaUrl = urlActual.replace('/' + id + '/edit', '');
        console.log('nueva url ' + nuevaUrl + '/' + id)
        axios.patch(urlActual, Estado)
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