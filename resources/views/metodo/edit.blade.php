@extends('adminlte::page')

@section('title', 'Metodo pago | Editar')
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
            <label for="nombre">Metodo</label>
            <input type="text" value="{{$metodo->metodo}}" class="form-control" id="metodo" name="metodo" placeholder="Ingrese el metodo de pago" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="actualizar('{{$metodo->id}}')" class="btn btn-primary">actualizar</button>
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
        var metodo = document.getElementsByName('metodo')[0].value;

        const Estado = {
            metodo: metodo,
            id: id
        }
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