@extends('adminlte::page')
@section('title', 'Finanzas')
@section('content_header')
@stop

@section('content')
<h1 id="titulo">Finanzas</h1>
<div class="row">
    <div class="col-6">
        <h2>Mes actual $ {{$totalPrecio}}</h2>
    </div>
    <div class="col-6">
        <h3 class="float float-right">Total año: ${{$totalGeneral}}</h3>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <label for="meses">Buscar por mes</label>
        <select onclick="filtrar(1);" class="form form-control" id="meses"></select>
    </div>
    <div class="col-4">
        <label for="plataforma">Plataforma</label>
        <select onclick="filtrar(0);" class="form form-control" id="plataforma">
            @foreach($plataformas as $plataforma)
            <option value="{{$plataforma->id}}">{{$plataforma->plataforma}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-4">
        <label for="trimestres">Buscar Trimestre</label>
        <select onclick="filtrar(2);" class="form form-control" id="trimestres"></select>
    </div>
</div>
<br />
<div style="display: flex;justify-content: center; align-items: center;">
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4 ">
                <div class="translate-middle">
                    <h4>Plataforma</h4>
                    <h4 id="plataform"></h4>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p id="card-txt" class="card-text"></p>
                    <p id="card-txt2" class="card-text"></p>
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
<script>
    const meses = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    let annioActual = new Date().getFullYear();
    let titulo = document.getElementById('titulo');
    titulo.innerHTML = 'Finanzas año ' + annioActual;
    const selectMeses = document.getElementById("meses");
    meses.forEach((mes, index) => {
        const opcion = document.createElement("option");
        opcion.value = index + 1; // Asignar valor numérico (1 a 12)
        opcion.text = mes; // Asignar nombre del mes
        selectMeses.appendChild(opcion);
    });

    const trimestres = [
        "Primer Trimestre (Enero - Marzo)",
        "Segundo Trimestre (Abril - Junio)",
        "Tercer Trimestre (Julio - Septiembre)",
        "Cuarto Trimestre (Octubre - Diciembre)"
    ];
    const trimestresRango = [{
            inicio: new Date(annioActual, 0, 1),
            fin: new Date(annioActual, 2, 31)
        }, // Primer trimestre (enero - marzo)
        {
            inicio: new Date(annioActual, 3, 1),
            fin: new Date(annioActual, 5, 30)
        }, // Segundo trimestre (abril - junio)
        {
            inicio: new Date(annioActual, 6, 1),
            fin: new Date(annioActual, 8, 30)
        }, // Tercer trimestre (julio - septiembre)
        {
            inicio: new Date(annioActual, 9, 1),
            fin: new Date(annioActual, 11, 31)
        } // Cuarto trimestre (octubre - diciembre)
    ];
    const mesesRango = [{
            inicio: new Date(annioActual, 0, 1),
            fin: new Date(annioActual, 0, 31)
        }, // Enero
        {
            inicio: new Date(annioActual, 1, 1),
            fin: new Date(annioActual, 1, (annioActual % 4 === 0 && annioActual % 100 !== 0) || (annioActual % 400 === 0) ? 29 : 28)
        }, // Febrero (28 o 29 días)
        {
            inicio: new Date(annioActual, 2, 1),
            fin: new Date(annioActual, 2, 31)
        }, // Marzo
        {
            inicio: new Date(annioActual, 3, 1),
            fin: new Date(annioActual, 3, 30)
        }, // Abril
        {
            inicio: new Date(annioActual, 4, 1),
            fin: new Date(annioActual, 4, 31)
        }, // Mayo
        {
            inicio: new Date(annioActual, 5, 1),
            fin: new Date(annioActual, 5, 30)
        }, // Junio
        {
            inicio: new Date(annioActual, 6, 1),
            fin: new Date(annioActual, 6, 31)
        }, // Julio
        {
            inicio: new Date(annioActual, 7, 1),
            fin: new Date(annioActual, 7, 31)
        }, // Agosto
        {
            inicio: new Date(annioActual, 8, 1),
            fin: new Date(annioActual, 8, 30)
        }, // Septiembre
        {
            inicio: new Date(annioActual, 9, 1),
            fin: new Date(annioActual, 9, 31)
        }, // Octubre
        {
            inicio: new Date(annioActual, 10, 1),
            fin: new Date(annioActual, 10, 30)
        }, // Noviembre
        {
            inicio: new Date(annioActual, 11, 1),
            fin: new Date(annioActual, 11, 31)
        } // Diciembre
    ];

    function filtrar(opcion) {
        var fechaInicio = null;
        var fechaFin = null;
        var seleccionMes = document.getElementById('meses').value;
        var seleccionTrimestre = document.getElementById('trimestres').value;
        if (opcion != 0) {
            var valor = localStorage.setItem('opcion', opcion);
        }
        var seleccionPlataforma = document.getElementById('plataforma').value;
        if (opcion == 0) {
            opcion = localStorage.getItem('opcion');
        }
        if (opcion == 1) {
            fechaInicio = mesesRango[seleccionMes - 1].inicio;
            fechaFin = mesesRango[seleccionMes - 1].fin;
        } else if (opcion == 2) {
            fechaInicio = trimestresRango[seleccionTrimestre - 1].inicio;
            fechaFin = trimestresRango[seleccionTrimestre - 1].fin;
        }
        var urlActual = window.location.href;
        var total = 0;
        const select = document.getElementById("plataforma");
        const texto = select.options[select.selectedIndex].text;
        axios.post(urlActual, {
                fechaInicio: fechaInicio.toLocaleDateString(),
                fechaFin: fechaFin.toLocaleDateString(),
                plataformaId: seleccionPlataforma
            })
            .then(response => {
                console.log(response.data.finanzas)
                response.data.finanzas.forEach(finanza => {
                    total = finanza.total_pagado + total;

                })
                document.getElementById('plataform').innerHTML = texto;
                document.getElementById('card-txt').innerHTML = 'Total ingresos para la fecha de ' + fechaInicio.toLocaleDateString() + ' a ' + fechaFin.toLocaleDateString();
                document.getElementById('card-txt2').innerHTML = '$' + total
            })
            .catch(error => {
                console.log(error)
                Swal.fire({
                    title: 'Ha ocurrido un error ' + error,
                    icon: 'error',
                })
            });
    }

    // Seleccionar el elemento <select> para los trimestres
    const selectTrimestres = document.getElementById("trimestres");

    trimestres.forEach((trimestre, index) => {
        const opcion = document.createElement("option");
        opcion.value = index + 1;
        opcion.text = trimestre;
        selectTrimestres.appendChild(opcion);
    });
    window.onload = function() {
        filtrar(1)
    }
</script>
@stop