@extends('adminlte::page')

@section('title', 'Pais')
@php
$breadcrumbs = Breadcrumbs::generate('home'); // Cambia a tu breadcrumb deseado
@endphp
@section('content_header')
<nav aria-label="breadcrumb">
    {{ Breadcrumbs::render('pais') }}
</nav>
@stop

@section('content')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Nuevo Pais
</button>
<form class="form-fixed float-right" action="/pais" method="get">
    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-sync"></i></button>
</form>
<form class="form-inline float-right" method="get" action="{{ route('pais.buscar') }}">
    <div class="form-group mb-2">
        <label for="buscar" class="sr-only">Buscar</label>
        <input type="text" class="form-control" id="buscar" name="buscar" placeholder="Pais a buscar">
    </div>
    <button type="submit" class="btn btn-success mb-2"><i class="fa fa-search"></i></button>
</form>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar un pais</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formPais" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre del pais</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del pais" />
                    </div>
                    <div class="form-group">
                        <label for="siglas">Siglas del pais</label>
                        <input type="text" class="form-control" id="siglas" name="siglas" placeholder="Siglas del pais ejemplo (GT , SV ,HN)" />
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
@if($paises->isEmpty())
<div class="container">
    <div class="row">
        <div class="col text-center">
            <div class="d-inline-block mx-auto">
                <h4>No se han encontrado datos para tu busqueda</h4>
                <form class="form-fixed float-" action="/pais" method="get">
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
            <th scope="col">Siglas</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($paises as $pais)
        <tr>
            <td>{{$pais->nombre}}</td>
            <td>{{$pais->siglas}}</td>
            <td>
                <a class="btn btn-info" href="{{url('pais/'.$pais->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                <a data-toggle="modal" data-target="#deleteModal" onclick="eliminar('{{$pais->id}}')" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
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
{{ $paises->links() }}
@endif

@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/admin_custom.css">
@stop

@section('js')
@vite('resources/js/app.js')
<script>
    function guardar() {
        var nombre = document.getElementById('nombre').value;
        var siglas = document.getElementById('siglas').value;
        var urlActual = window.location.href;
        axios.post(urlActual, {
                siglas: siglas,
                nombre: nombre
            })
            .then(response => {
                console.log(response)
                Swal.fire({
                    title: 'Registrado ',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href=urlActual;
                    }
                })
            })
            .catch(error => {
                console.log(error)
                Swal.fire({
                    title: 'Ha ocurrido un error',
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
        localStorage.setItem('idPais', id);
    }

    function condirmarEliminar() {

        const id = localStorage.getItem('idPais');
        var urlActual = window.location.href;
        axios.delete('/pais/' + id)
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