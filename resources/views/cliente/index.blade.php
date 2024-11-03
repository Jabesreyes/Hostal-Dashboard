@extends('adminlte::page')

@section('title', 'Clientes')
@php
@endphp
@section('content_header')
@stop

@section('content')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Nuevo Cliente
</button>
<form class="form-fixed float-right" action="/cliente" method="get">
    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-sync"></i></button>
</form>
<form class="form-inline float-right" action="{{ url('/cliente') }}" method="GET">
    <div class="form-group mb-2">
        <label for="buscar" class="sr-only">Buscar</label>
        <input type="text" class="form-control" id="buscar" value="{{ request('buscar') }}" name="buscar" placeholder="Buscar cliente">
    </div>
    <button type="submit" class="btn btn-success mb-2"><i class="fa fa-search"></i></button>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar un cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                @csrf
                @method('post')
                <div class="modal-body row">
                    <div class="col">
                        <label for="nombre">Nombre del cliente</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre completo del cliente" />
                        <label for="pais_id">Pais de residencia</label>
                        <select data-live-search="true" class="selectpicker form-control" name="pais_id" id="pais_id">
                            @foreach ($paises as $pais)
                            <option value="{{ $pais->id}}">{{ $pais->nombre }}</option>
                            @endforeach
                        </select>
                        <label for="telefono">Numero de telefono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Numero de telefono" />
                        <label for="correo">Correo electronico</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electronico" />
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
@if($clientes->isEmpty())
<div class="container">
    <div class="row">
        <div class="col text-center">
            <div class="d-inline-block mx-auto">
                <h4>No se han encontrado datos</h4>
                <form class="form-fixed float-" action="/cliente" method="get">
                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-sync"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Telefono</th>
            <th scope="col">Pais</th>
            <th scope="col">Correo</th>
            <th scope="col">Registro</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
        <tr>
            <td>{{$cliente->nombre}}</td>
            <td>{{$cliente->telefono}}</td>
            <td>{{$cliente->pais->nombre}}</td>
            <td>{{$cliente->correo}}</td>
            <td>{{$cliente->registro}}</td>
            <td>
                <a class="btn btn-info" href="{{url('cliente/'.$cliente->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                <a data-toggle="modal" data-target="#deleteModal" onclick="eliminar('{{$cliente->id}}')" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Seguro que deseas realizar esta accion?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                <button type="button" id="conf" class="btn btn-danger" data-dismiss="modal" onclick="condirmarEliminar()" value="confirmar">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $clientes->appends(['buscar' => request('buscar')])->links() }}
@endif

@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" rel="stylesheet">
@stop

@section('js')
@vite('resources/js/app.js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
<script>
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
        var nombre = document.getElementById('nombre').value;
        var telefono = document.getElementById('telefono').value;
        var correo = document.getElementById('correo').value;
        var pais_id = document.getElementById('pais_id').value;

        var urlActual = window.location.href;
        let url = urlActual.indexOf("/cliente") + "/cliente".length;
        let resultadoURL = urlActual.substring(0, url);


        axios.post(resultadoURL, {
                nombre: nombre,
                telefono: telefono,
                correo: correo,
                registro: obtenerFechaHoraFormateada(),
                pais_id: pais_id,
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
    };

    function search() {
        let searchQuery = document.getElementById('buscar').value;
        alert(searchQuery)
        axios.get('/cliente?buscar=' + searchQuery)
            .then(response => {
                alert(response.data)
            }).catch(error => {
                Swal.fire({
                    title: 'Cliente no encontrado',
                    icon: 'error',
                })
            })
    };

    function eliminar(id) {
        localStorage.setItem('idCliente', id);
    }

    function condirmarEliminar() {

        const id = localStorage.getItem('idCliente');
        var urlActual = window.location.href;
        let url = urlActual.indexOf("/cliente") + "/cliente".length;
        let resultadoURL = urlActual.substring(0, url);
        axios.delete(resultadoURL+'/' + id)
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
@stop