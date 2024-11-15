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
                    <input type="hidden" id="habitacion" />
                    <h5 id="estadoReserva" class="alert alert-success" role="alert"></h5>
                    @foreach($estadoreservas as $estado)
                    <div class="form-group">
                        <label>
                            <input type="radio" name="opcionRadio" value="{{$estado->id}}">
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
<form>
    <label for="semanas">Seleccione una semana:</label>
    <select onchange="obtenerFechas();" id="semanas" class="form form-control">
    </select>
</form>
<br />
<div id="contenedor-tarjetas" class="card-deck">
</div>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop

@section('js')
@vite('resources/js/app.js')
<script>
    function dividirMesEnSemanas() {
        const semanas = [];
        let semana = [];
        const fechaActual = new Date();
        const annio = fechaActual.getFullYear(); // Año en números
        const mes = fechaActual.getMonth() + 1;
        const primerDia = new Date(annio, mes - 1, 1); // Primer día del mes
        const ultimoDia = new Date(annio, mes, 0); // Último día del mes
        // Iteramos desde el primer día hasta el último día del mes
        for (let dia = primerDia; dia <= ultimoDia; dia.setDate(dia.getDate() + 1)) {
            semana.push(new Date(dia)); // Agregamos el día actual a la semana
            // Si es sábado o el último día del mes, cerramos la semana actual
            if (dia.getDay() === 6 || dia.getDate() === ultimoDia.getDate()) {
                semanas.push(semana); // Añadimos la semana al array de semanas
                semana = []; // Reiniciamos el array de la semana
            }
        }
        return semanas;
    }

    function mostrarSemanasEnSelect() {
        const semanas = dividirMesEnSemanas();
        const select = document.getElementById("semanas");
        select.innerHTML = ""; // Limpiar el select
        // Iteramos sobre cada semana y creamos una opción en el select
        const opcion2 = document.createElement("option");
        opcion2.value = null;
        opcion2.textContent = '---Seleccione---';
        select.appendChild(opcion2);
        semanas.forEach((semana, index) => {
            const inicio = semana[0];
            const fin = semana[semana.length - 1];
            const opcion = document.createElement("option");
            opcion.value = `Semana ${index + 1}`;
            opcion.textContent = `Semana ${index + 1}: ${inicio.toLocaleDateString()} - ${fin.toLocaleDateString()}`;
            select.appendChild(opcion);
        });
    }
    mostrarSemanasEnSelect();
</script>
<script>
    //funcion para obtener el rango de fechas del select seleccionado
    function obtenerFechas() {
        const select = document.getElementById("semanas");
        const texto = select.options[select.selectedIndex].text;
        const rangoFechas = texto.split(": ")[1];
        const [fechaInicio, fechaFin] = rangoFechas.split(" - ");
        var urlActual = window.location.href;
        axios.post(urlActual, {
                fechaInicio: fechaInicio,
                fechaFin: fechaFin,
            }).then(response => {
                document.getElementById('contenedor-tarjetas').innerHTML = '';
                if (response.data.reservas != 0) {
                    response.data.reservas.forEach(reserva => {
                        crearTarjetaReserva(reserva);
                    });
                } else {
                    const h2 = document.createElement('h4');
                    h2.innerHTML = 'No se han encontrado reservas para las fechas: ' + fechaInicio + ' y ' + fechaFin;
                    document.getElementById('contenedor-tarjetas').appendChild(h2);
                }
            })
            .catch(error => {
                console.log(error.data)
            });
    }

    function crearTarjetaReserva(reserva) {
        // Crear el contenedor de la tarjeta
        const card = document.createElement('div');
        card.className = 'card info-box bg-primary';
        // Crear el enlace que abre el modal
        const link = document.createElement('a');
        link.href = '#';
        link.setAttribute('data-toggle', 'modal');
        link.setAttribute('data-target', '#exampleModal');
        link.onclick = function() {
            guardarId(reserva.id, reserva.estado_reservas.id, reserva.estado_reservas.estado, reserva.habitacions.id);
        };

        // Crear el ícono
        const iconSpan = document.createElement('span');
        iconSpan.className = 'info-box-icon';
        const icon = document.createElement('i');
        icon.className = 'fa fa-bed';
        iconSpan.appendChild(icon);

        // Crear el contenido de la tarjeta
        const contentDiv = document.createElement('div');
        contentDiv.className = 'info-box-content';

        // Crear cada línea de texto dentro de la tarjeta
        const clienteText = document.createElement('span');
        clienteText.className = 'info-box-text';
        clienteText.textContent = `Cliente: ${reserva.clientes.nombre}`;

        const habitacionText = document.createElement('span');
        habitacionText.className = 'info-box-text';
        habitacionText.textContent = `Habitación: ${reserva.habitacions.numero} ${reserva.habitacions.nombre}`;

        const ingresoText = document.createElement('span');
        ingresoText.className = 'info-box-text';
        ingresoText.textContent = `Ingreso: ${reserva.fecha_ingreso}`;

        const retiroText = document.createElement('span');
        retiroText.className = 'info-box-text';
        retiroText.textContent = `Retiro: ${reserva.fecha_retiro}`;

        const estadoText = document.createElement('span');
        estadoText.className = 'info-box-number';
        estadoText.textContent = `Estado del cliente: ${reserva.estado_reservas.estado}`;

        const precioText = document.createElement('span');
        precioText.className = 'info-box-number';
        precioText.textContent = `Precio 24 Horas: $ ${reserva.precio_dia}`;

        const totalText = document.createElement('span');
        totalText.className = 'info-box-number';
        totalText.textContent = `Total: ${reserva.total_pagado}`;

        // Agregar cada elemento de texto al contenedor de contenido
        contentDiv.appendChild(clienteText);
        contentDiv.appendChild(habitacionText);
        contentDiv.appendChild(ingresoText);
        contentDiv.appendChild(retiroText);
        contentDiv.appendChild(estadoText);
        contentDiv.appendChild(precioText);
        contentDiv.appendChild(totalText);

        // Construir la estructura final de la tarjeta
        link.appendChild(iconSpan);
        link.appendChild(contentDiv);
        card.appendChild(link);

        // Insertar la tarjeta en el DOM,dentro del contenedor con id "contenedor-tarjetas"
        document.getElementById('contenedor-tarjetas').appendChild(card);
    }
</script>
<script>
    function mostrarModal() {
        var modal = document.getElementById('exampleModal');
        modal.setAttribute('data-toggle', "modal");

    }
    const fechaActual = new Date();
    const opciones = {
        year: 'numeric',
        month: 'long',
    };
    const fechaFormateada = fechaActual.toLocaleDateString('es-ES', opciones);
    var xfecha = document.getElementById('fechanow');
    xfecha.innerHTML = "Reservas para " + fechaFormateada;

    function guardarId(id, idestado, estado, id_habitacion) {
        localStorage.setItem('idReservacheckin', id);
        var x = document.getElementById('estadoReserva');
        x.innerHTML = 'Estado actual: ' + estado;
        const radios = document.getElementsByName("opcionRadio");
        var habitacion = document.getElementById('habitacion');
        habitacion.value = id_habitacion;
        radios.forEach(radio => {
            if (radio.value == idestado) {
                radio.checked = true; // Selecciona el radiobutton con valor '2'
            }
        });
    }

    function guardar() {
        const opcion = document.querySelector('input[name="opcionRadio"]:checked').value;
        var id = localStorage.getItem('idReservacheckin');
        var habitacion = document.getElementById('habitacion').value;
        var urlActual = window.location.href;
        let url = urlActual.replace("/checkin", '/reserva/' + id);
        axios.patch(url, {
                estado_reservas_id: opcion,
                id: id
            })
            .then(response => {
                var urlhabitacion = window.location.href;
                let urlhabitacion2 = urlhabitacion.replace("/checkin", '/habitacion/' + habitacion + '/edit');
                console.log(urlhabitacion2 + ' url habitacion');
                axios.patch(urlhabitacion2, {
                    estados_id: 2,
                    id: habitacion,
                })
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