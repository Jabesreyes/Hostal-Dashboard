@extends('adminlte::page')

@section('title', 'Dashboard')
@php
$breadcrumbs = Breadcrumbs::generate('home'); // Cambia a tu breadcrumb deseado
@endphp
@section('content_header')
<nav aria-label="breadcrumb">
    {{ Breadcrumbs::render('home') }}
</nav>
@stop

@section('content')
<div class="card-deck">
    <div class=" card info-box bg-primary">
        <span class="info-box-icon"><i class="fa fa-bed"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Total Habitaciones</span>
            <span class="info-box-number">{{$habitaciones}}</span>
        </div>
    </div>
    <div class=" card info-box bg-success">
        <span class="info-box-icon"><i class="fas fa-home"></i> <i class="fas fa-check"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Habitaciones libres</span>
            <span class="info-box-number">{{$habitacionesLibres}}</span>
        </div>
    </div>
    <div class="card info-box bg-danger">
        <span class="info-box-icon"><i class="fas fa-key"></i> <i class="fas fa-times"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Habitaciones ocupadas</span>
            <span class="info-box-number">{{$habitacionesOcupadas}}</span>
        </div>
    </div>
    <div class="card info-box bg-warning">
        <span class="info-box-icon"><i class="fas fa-key"></i> <i class="fas fa-times"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Habitaciones mantenimiento</span>
            <span class="info-box-number">{{$habitacionesMantenimiento}}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <h5>Plataformas con mas reservas del mes</h5>
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-3">
        <h5>Ingresos mensual por plataforma</h5>
        <canvas id="myChartBar"></canvas>
    </div>
    <div class="col-6">
        <h5>Ultimas 5 reservas</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Fecha de reserva</th>
                    <th scope="col">Fecha de Ingreso</th>
                    <th scope="col">Fecha de Retiro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ultimasReservas as $reservas)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$reservas->clientes->nombre}}</td>
                    <td>{{$reservas->fecha_reserva}}</td>
                    <td>{{$reservas->fecha_ingreso}}</td>
                    <td>{{$reservas->fecha_retiro}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop

@section('js')
<script>
    function generarGrafico() {
        const url = window.location.href;
        const urlN = url + 'graficoCircular'
        fetch(urlN)
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.plataforma || 'Sin Plataforma'); // Nombres o IDs de plataformas
                const valores = data.map(item => item.total_reservas); // Totales por plataforma

                const ctx = document.getElementById('myChart');
                new Chart(ctx, {
                    type: 'doughnut', // Tipo de gráfico (puede ser 'line', 'pie', etc.)
                    data: {
                        labels: labels, // Ejes X
                        datasets: [{
                            label: 'Reservas',
                            data: valores, // Valores en el eje Y
                            borderWidth: 2 // Ancho del borde
                        }]
                    },

                });
            })
            .catch(error => {
                console.error('Error al obtener datos:', error);
            });
        const urlBar = url + 'graficoBarra'
        fetch(urlBar)
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.plataforma || 'Sin Plataforma'); // Nombres o IDs de plataformas
                const valores = data.map(item => item.totalPrecio); // Totales por plataforma

                const ctx2 = document.getElementById('myChartBar');
                new Chart(ctx2, {
                    type: 'bar', // Tipo de gráfico (puede ser 'line', 'pie', etc.)
                    data: {
                        labels: labels, // Ejes X
                        datasets: [{
                            label: 'Ingreso $',
                            data: valores, // Valores en el eje Y
                            borderWidth: 2, // Ancho del borde
                            backgroundColor: function(context) {
                                const index = context.dataIndex;
                                return randomColor(); // Asigna un color aleatorio a cada barra
                            },
                        }]
                    },

                });
            })
            .catch(error => {
                console.error('Error al obtener datos:', error);
            });
    }

    function randomColor() {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        return `rgb(${r}, ${g}, ${b})`;
    }
    window.onload = generarGrafico
</script>
@stop