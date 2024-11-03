@extends('adminlte::page')

@section('title', 'Estado Habitacion')
<link href='https://unpkg.com/fullcalendar@5.11.3/main.css' rel='stylesheet' />
@section('content_header')
@stop

@section('content')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Nueva reserva
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar una reserva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body row">
                    <div class="col-12">
                        <label for="nombre">Seleccione Cliente</label>
                        <select data-live-search="true" class="selectpicker form-control" name="cliente" id="cliente">
                            <option>---Seleccione---</option>
                            @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id}}">{{ $cliente->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="habitacion">Seleccione habitacion</label>
                        <select onchange="mostrarPrecio();" data-live-search="true" class="selectpicker form-control" name="habitacion" id="habitacion">
                            <option value="null">Seleccione</option>
                            @foreach ($habitacions as $habitacion)
                            <option value="{{ $habitacion->id}}">Habitacion N° {{ $habitacion->numero}} {{ $habitacion->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="plataforma">Plataforma de reserva</label>
                        <select data-live-search="true" class="selectpicker form-control" name="plataforma" id="plataforma">
                            <option value="null">Seleccione</option>
                            @foreach ($plataformas as $plataforma)
                            <option value="{{ $plataforma->id}}">{{ $plataforma->plataforma}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="inicio">Desde</label>
                        <input type="text" onchange="calcularDias();" class="form-control" id="inicio" name="inicio" placeholder="Fecha de inicio">
                    </div>
                    <div class="col-6">
                        <label for="hasta">Hasta</label>
                        <input type="text" onchange="calcularDias();" class="form-control" id="fin" name="fin" placeholder="Seleccione el dia final">
                    </div>

                    <div class="col-6">
                        <label for="inicio">Precio 24 Horas</label>
                        <input type="text" value="0" readonly disabled class="form-control" id="precio" name="precio" placeholder="precio 24 H">
                    </div>
                    <div class="col-6">
                        <label for="metodo">Metodo de pago</label>
                        <select data-live-search="true" class="selectpicker form-control" name="metodo" id="metodo">
                            <option value="null">Seleccione</option>
                            @foreach ($metodos as $metodo)
                            <option value="{{ $metodo->id}}">{{ $metodo->metodo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="total">Total a pagar</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" readonly id="total" value="0.0" name="total" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="capacidad">Capacidad</label>
                        <input type="text" value="0" readonly class="form-control" id="capacidad" name="capacidad" placeholder="Capacidad">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" data-dismiss="modal" onclick="guardar();" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="text-center">
    <form>
        @foreach($habitacions as $habitacion)
        <label>Habitacion {{$habitacion->numero}} {{$habitacion->nombre}}</label>
        <input type="color" disabled readonly value="{{$habitacion->color}}" />
        @endforeach
    </form>
</div>
<div id='calendar'></div>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@stop

@section('js')
@vite('resources/js/app.js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src='https://unpkg.com/fullcalendar@5.11.3/main.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    function calcularDias() {
        // Obtener las fechas de los inputs
        const fechaInicio = new Date(document.getElementById('inicio').value);
        const fechaFin = new Date(document.getElementById('fin').value);
        const diferencia = fechaFin - fechaInicio;
        const dias = diferencia / (1000 * 60 * 60 * 24);
        const precio = document.getElementById('precio').value;
        document.getElementById('total').value = (precio * parseInt(dias));
    }

    function mostrarPrecio() {
        var x = document.getElementById('habitacion').value;
        var urlActual = window.location.href;
        let url = urlActual.replace("/reserva", '/habitacion/buscar');
        axios.get(url + '/' + x)
            .then(response => {
                // Muestra los datos de la habitación en el resultado
                document.getElementById('precio').value = response.data.precio;
                document.getElementById('capacidad').value = response.data.capacidad + ' Personas';
                calcularDias();
            })
            .catch(error => {
                if (error.response.status === 404) {
                    document.getElementById('precio').textContent =
                        'Precio no valido';
                } else {
                    console.error(error);
                }
            });
    }
    flatpickr("#inicio", {
        enableTime: true, // Habilita la selección de hora
        dateFormat: "Y-m-d H:i:S", // Formato de fecha y hora
    });
    flatpickr("#fin", {
        enableTime: true, // Habilita la selección de hora
        dateFormat: "Y-m-d H:i:S", // Formato de fecha y hora
    });
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es', // Establece el idioma en español
            height: 550,
            timeZone: 'local',
            events: function(fetchInfo, successCallback, failureCallback) {
                // Hacer la solicitud con Axios para obtener las reservas
                var urlActual = window.location.href;
                let url = urlActual.indexOf("/reserva") + "/reserva".length;
                let resultadoURL = urlActual.substring(0, url);
                axios.get(resultadoURL + '/calendario')
                    .then(response => {
                        successCallback(response.data); // Pasar los eventos al calendario
                    })
                    .catch(error => {
                        console.error('Error al cargar reservas:', error);
                        failureCallback(error);
                    });
            },
            eventContent: function(arg) {
                // Crear un contenedor div para el evento
                let title = document.createElement('div');
                title.innerHTML = arg.event.title; // El título principal (nombre del cliente)

                let habitacion = document.createElement('div');
                habitacion.innerHTML = arg.event.extendedProps.habitacion; // El subtítulo (precio por día, etc.)
                habitacion.style.fontSize = '0.85em'; // Opcional, para ajustar el tamaño del subtítulo
                // Retornar ambos elementos dentro de un fragmento de documento
                let arrayOfDomNodes = [title, habitacion];
                return {
                    domNodes: arrayOfDomNodes
                };
            }, // Usa eventos estáticos
            eventClick: function(info) {
                Swal.fire({
                    title: "Detalles de la reserva",
                    html: 'Cliente: ' + info.event.title + "<br>Desde: " + formatoFecha(info.event.start) + "<br>Hasta: " + formatoFecha(info.event.end),
                });
            },
            dayCellDidMount: function(info) {
                var today = new Date();
                if (
                    info.date.getDate() === today.getDate() &&
                    info.date.getMonth() === today.getMonth() &&
                    info.date.getFullYear() === today.getFullYear()
                ) {
                    // Cambia el color de fondo y el color del texto del día actual
                    info.el.style.backgroundColor = '#c0d7d3'; // Cambiar color de fondo
                    info.el.style.color = 'black'; // Cambiar color del texto
                }
            }
        });

        calendar.render();
    });
    //salida de fecha en formato 10 de enero de 2024
    function formatoFecha(info) {
        const fecha = new Date(info);
        const dia = fecha.getDate(); // Día del mes
        const anio = fecha.getFullYear(); // Año completo
        const opcionesHora = {
            hour: '2-digit',
            minute: '2-digit'
        };
        const meses = [
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];
        const hora = fecha.toLocaleTimeString('es-SV', opcionesHora);
        const mes = meses[fecha.getMonth()];
        return fechaFormateada = `${dia} de ${mes} de ${anio}, ${hora}`;
    }

    function obtenerFechaHoraFormateada() {
        const fechaActual = new Date();

        const dia = String(fechaActual.getDate()).padStart(2, '0');
        const mes = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses son indexados desde 0
        const anio = fechaActual.getFullYear();
        const horas = String(fechaActual.getHours()).padStart(2, '0');
        const minutos = String(fechaActual.getMinutes()).padStart(2, '0');
        const segundos = String(fechaActual.getSeconds()).padStart(2, '0');

        return `${anio}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;
    }

    function guardar() {
        var clientes_id = document.getElementById('cliente').value;
        var habitacions_id = document.getElementById('habitacion').value;
        var fecha_ingreso = document.getElementById('inicio').value;
        var fecha_retiro = document.getElementById('fin').value;
        var plataformas_id = document.getElementById('plataforma').value;
        var metodo_pagos_id = document.getElementById('metodo').value;
        var total_pagado = document.getElementById('total').value;
        var precio_dia = document.getElementById('precio').value;

        var urlActual = window.location.href;
        let url = urlActual.indexOf("/reserva") + "/reserva".length;
        let resultadoURL = urlActual.substring(0, url);

        axios.post(resultadoURL + '/validar', {
            habitacions_id: habitacions_id,
            fecha_ingreso: fecha_ingreso,
            fecha_retiro: fecha_retiro
        }).then(response => {
            if (response.data.mensaje) {
                axios.post(resultadoURL, {
                        clientes_id: clientes_id,
                        habitacions_id: habitacions_id,
                        fecha_ingreso: fecha_ingreso,
                        fecha_retiro: fecha_retiro,
                        plataformas_id: plataformas_id,
                        metodo_pagos_id: metodo_pagos_id,
                        total_pagado: total_pagado,
                        fecha_reserva: obtenerFechaHoraFormateada(),
                        precio_dia: precio_dia,
                        estado_reservas_id:4
                    })
                    .then(response => {
                        console.log(response)
                        Swal.fire({
                            title: 'Registrado ',
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
            } else {
                Swal.fire({
                    title: 'Habitacion ya esta reservada en estas fechas',
                    icon: 'warning',
                    text: response.data.error + ''
                })
            }

        });
        /* axios.post(resultadoURL, {
                 clientes_id: clientes_id,
                 habitacions_id: habitacions_id,
                 fecha_ingreso: fecha_ingreso,
                 fecha_retiro: fecha_retiro,
                 plataformas_id: plataformas_id,
                 metodo_pagos_id: metodo_pagos_id,
                 total_pagado: total_pagado,
                 fecha_reserva: obtenerFechaHoraFormateada(),
                 precio_dia: precio_dia
             })
             .then(response => {
                 console.log(response)
                 Swal.fire({
                     title: 'Registrado ',
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
             }); */
    };

    function search() {
        let searchQuery = document.getElementById('buscar').value;
        alert(searchQuery)
        axios.get('/pais?buscar=' + searchQuery)
            .then(response => {
                alert(response.data)
            }).catch(error => {
                Swal.fire({
                    title: 'Pais no encontrado',
                    icon: 'error',
                })
            })
    };

    function eliminar(id) {
        localStorage.setItem('idEstado', id);
    }

    function condirmarEliminar() {

        const id = localStorage.getItem('idEstado');
        var urlActual = window.location.href;
        axios.delete('/estado/' + id)
            .then(function(response) {
                Swal.fire({
                    title: "Eliminado",
                    text: "Registro eliminado",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    var d = document.querySelector('#conf');
                    d.setAttribute('data-dismiss', 'modal');
                    axios.get(urlActual).then(function(response) {
                            window.location.href = urlActual;
                        })
                        .catch(function(error) {
                            console.log('error get' + error);
                        });
                });
            })
            .catch(function(error) {
                Swal.fire({
                    title: "Error",
                    text: "Registro no eliminado",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                })
            });
    }
</script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
@stop