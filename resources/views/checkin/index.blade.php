@extends('adminlte::page')
@section('title', 'Check In')
@section('content_header')
@stop

@section('content')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Estado de la reserva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <h5 id="estadoReserva" class="alert alert-success" role="alert"></h5>
                    @foreach($estadoreservas as $estado)
                    <div class="form-group">
                        <label>
                            <input type="radio" name="opcion" value="{{$estado->id}}">
                            {{$estado->estado}}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" data-dismiss="modal" onclick="guardar();" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br />
<h5 id="fechanow"></h5>
<br />
<div class="card-deck">
    @foreach($reservas as $reserva)
    <div class=" card info-box bg-primary">
        <a onclick="guardarId('{{$reserva->id}}','{{$reserva->estado_reservas->id}}','{{$reserva->estado_reservas->estado}}')" href="#" data-toggle="modal" data-target="#exampleModal">
            <span class="info-box-icon"><i class="fa fa-bed"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Cliente: {{$reserva->clientes->nombre}}</span>
                <span class="info-box-text">Ingreso: {{$reserva->fecha_ingreso}}</span>
                <span class="info-box-text">Retiro:{{$reserva->fecha_retiro}}</span>
                <span class="info-box-number">Estado del cliente :{{$reserva->estado_reservas->estado}}</span>
                <span class="info-box-number">Precio 24 Horas: $ {{$reserva->precio_dia}}</span>
                <span class="info-box-number">Total :{{$reserva->total_pagado}}</span>
            </div>
        </a>
    </div>
    @endforeach
</div>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop

@section('js')
@vite('resources/js/app.js')
<script>
    function mostrarModal() {
        var modal = document.getElementById('exampleModal');
        modal.setAttribute('data-toggle', "modal");

    }
    const fechaActual = new Date();
    const opciones = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const fechaFormateada = fechaActual.toLocaleDateString('es-ES', opciones);
    var xfecha = document.getElementById('fechanow');
    xfecha.innerHTML = "Reservas para hoy " + fechaFormateada;

    function guardarId(id, idestado, estado) {
        localStorage.setItem('idReservacheckin', id);
        var x = document.getElementById('estadoReserva');
        x.innerHTML = 'Estado actual: ' + estado;
        const radios = document.getElementsByName("opcion");
        radios.forEach(radio => {
            if (radio.value === idestado) {
                radio.checked = true; // Selecciona el radiobutton con valor '2'
            }
        });
    }

    function guardar() {
        const opcion = document.querySelector('input[name="opcion"]:checked').value;
        var id = localStorage.getItem('idReservacheckin')
        var urlActual = window.location.href;
        let url = urlActual.replace("/checkin", '/reserva/' + id);
        axios.patch(url, {
                estado_reservas_id: opcion,
                id: id
            })
            .then(response => {
                console.log(response)
                Swal.fire({
                    title: 'Reserva actualizada',
                    icon: 'success',
                }).then((result) => {
                    window.location.href = window.location.href;
                });
            })
            .catch(error => {
                console.log(error)
                Swal.fire({
                    title: 'Ha ocurrido un error ' + error,
                    icon: 'error',
                })
            });
    };
</script>
@stop