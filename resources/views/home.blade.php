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
    <div class="col-4">
        <canvas id="myChart"></canvas>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop

@section('js')
<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Red', 'Blue', 'Green'],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Custom Chart Title'
            }
        }
    });
</script>
@stop