@extends('adminlte::page')

@section('title', 'Estado Reserva')
@php
@endphp
@section('content_header')
@stop

@section('content')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Nuevo estado
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar un estado para la reserva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado" placeholder="Ingrese el estado de la reserva" />
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
@if($estados->isEmpty())
<div class="container">
    <div class="row">
        <div class="col text-center">
            <div class="d-inline-block mx-auto">
                <h4>No se han encontrado datos</h4>
                <form class="form-fixed float-" action="/estadoreserva" method="get">
                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-sync"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($estados as $estado)
        <tr>
            <td>{{$estado->estado}}</td>
            <td>
                <a class="btn btn-info" href="{{url('estadoreserva/'.$estado->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                <a data-toggle="modal" data-target="#deleteModal" onclick="eliminar('{{$estado->id}}')" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
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
{{ $estados->links() }}
@endif

@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop

@section('js')
@vite('resources/js/app.js')
<script>
    function guardar() {
        var estado = document.getElementById('estado').value;
        var urlActual = window.location.href;
        let url = urlActual.indexOf("/estadoreserva") + "/estadoreserva".length;
        let resultadoURL = urlActual.substring(0, url);
        axios.post(resultadoURL, {
                estado: estado,
            })
            .then(response => {
                console.log(response)
                Swal.fire({
                    title: 'Registrado ',
                    icon: 'success',
                }).then((result) => {
                    window.location.href = urlActual;
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
        localStorage.setItem('idEstadoReserva', id);
    }

    function condirmarEliminar() {
        const id = localStorage.getItem('idEstadoReserva');
        var urlActual = window.location.href;
        let url = urlActual.indexOf("/estadoreserva") + "/estadoreserva".length;
        let resultadoURL = urlActual.substring(0, url);
        axios.delete(resultadoURL + '/' + id)
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