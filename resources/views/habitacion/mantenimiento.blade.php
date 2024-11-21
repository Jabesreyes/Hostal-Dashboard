@extends('adminlte::page')
@section('title', 'Mantenimiento')
@section('content_header')
@stop

@section('content')
<br />
<div class="row">
    @if($habitaciones->isEmpty())
    <div class="container">
    <div class="row">
        <div class="col text-center">
            <div class="d-inline-block mx-auto">
                <h4>No se han encontrado habitaciones en mantenimiento o limpieza</h4>
                <form class="form-fixed float-" action="/habitacion/mantenimiento" method="get">
                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-sync"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
    @else
    <h4>Habitaciones en mantenimiento o limpieza</h4>
    @foreach($habitaciones as $habitacion)
    <div class="col-4">
        <a onclick="guardarId('{{$habitacion->id}}')" data-toggle="modal" data-target="#exampleModal" href="#" class="card-link">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Habitacion: {{$habitacion->nombre}}</h3>
                    <h6 class="card-text">Numero: {{$habitacion->numero}}</h6>
                    <h6 class="card-text">Estado: {{$habitacion->estados->estado}}</h6>
                    <h6 class="card-text">Capacidad: {{$habitacion->capacidad}} personas</h6>
                    <h6 class="card-text">Descripcion: {{$habitacion->descripcion}}</h6>
                    <h6 class="card-text">Precio 24 Horas: {{$habitacion->precio}} </h6>
                    <h6 class="card-text">Precio Promocional: {{$habitacion->precio_promocion}}</h6>
                    <a class="card-link">

                    </a>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Terminar Mantenimiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio1" value="1" name="customRadio" class="custom-control-input">
                    <label class="custom-control-label" for="customRadio1">Si</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio2" value="0" checked name="customRadio" class="custom-control-input">
                    <label class="custom-control-label" for="customRadio2">No</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="guardar()" class="btn btn-success">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
@stop
@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop

@section('js')
@vite('resources/js/app.js')
<script>
    function guardarId(id) {
        localStorage.setItem('idMantenimiento', id);
    }

    function guardar() {
        const radios = document.getElementsByName('customRadio');
        const idMantenimiento = localStorage.getItem('idMantenimiento');
        var seleccionado = false;
        for (const radio of radios) {
            if (radio.checked) {
                seleccionado = radio.value;
            }
        }
        var urlActual = window.location.href;
        var nuevaUrl = urlActual.replace('habitacion/mantenimiento', 'habitacion/' + idMantenimiento + '/edit');
        console.log('nueva url ' + nuevaUrl + '/' + 1)
        axios.patch(nuevaUrl, {
                estados_id: 1,
                id: idMantenimiento
            })
            .then(response => {
                Swal.fire({
                    title: "Actualizado",
                    text: "Mantenimiento finalizado",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    window.location.href = urlActual;
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
                    window.location.href = urlActual;
                });
            });
    }
</script>
@stop