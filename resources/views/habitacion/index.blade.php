@extends('adminlte::page')

@section('title', 'Habitaciones')
@php
@endphp
@section('content_header')
@stop

@section('content')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Nueva habitacion
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar una habitacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                @csrf
                @method('post')
                <div class="modal-body row">
                    <div class="col-6">
                        <label for="numero">Numero de la Habitacion</label>
                        <input type="number" class="form-control" id="numero" name="numero" placeholder="Numero de la habitacion" />
                        <label for="nombre">Nombre de la Habitacion</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre de la habitacion" />
                    </div>
                    <div class="col-6">
                        <label for="capacidad">Capacidad de la Habitacion</label>
                        <input type="number" class="form-control" id="capacidad" name="capacidad" placeholder="Capacidad de la habitacion" />
                        <label for="descripcion">Descripcion de la Habitacion</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion de la habitacion" />

                    </div>
                    <div class="col-6">
                        <label for="estado">Estado de la habitacion</label>
                        <select class="form-control" name="estado" id="estado">
                            @foreach ($estados as $estado)
                            <option value="{{ $estado->id}}">{{ $estado->estado }}</option>
                            @endforeach
                        </select>
                        <label for="precio">Precio de la Habitacion 24 H</label>
                        <input type="text" class="form-control" id="precio" name="precio" placeholder="precio de la habitacion" />
                    </div>
                    <div class="col-6">
                        <label for="precio_promocion">Precio de promocion</label>
                        <input type="text" value="0.0" class="form-control" id="precio_promocion" name="precio_promocion" placeholder="precio promocional de la habitacion" />
                        <label for="color">Color para la reserva</label>
                        <input class="form-control" type="color" id="color" value="#000000">
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
@if($habitaciones->isEmpty())
<div class="container">
    <div class="row">
        <div class="col text-center">
            <div class="d-inline-block mx-auto">
                <h4>No se han encontrado datos</h4>
                <form class="form-fixed float-" action="/habitacion" method="get">
                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-sync"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<br/><br/>
<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Numero</th>
            <th scope="col">Capacidad</th>
            <th scope="col">Estado</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Color de reserva</th>
            <th scope="col">Precio 24 horas</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($habitaciones as $habitacion)
        <tr>
            <td>{{$habitacion->nombre}}</td>
            <td>{{$habitacion->numero}}</td>
            <td>{{$habitacion->capacidad}} personas</td>
            <td>{{$habitacion->estados->estado}}</td>
            <td>{{$habitacion->descripcion}}</td>
            <td><input type="color" readonly="true" disabled id="colorPicker" value="{{$habitacion->color}}"></td>
            <td>$ {{$habitacion->precio}}</td>
            <td>
                <a class="btn btn-info" href="{{url('habitacion/'.$habitacion->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                <a data-toggle="modal" data-target="#deleteModal" onclick="eliminar('{{$habitacion->id}}')" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
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
        var nombre = document.getElementById('nombre').value;
        var precio = document.getElementById('precio').value;
        var precio_promocion = document.getElementById('precio_promocion').value;
        var numero = document.getElementById('numero').value;
        var capacidad = document.getElementById('capacidad').value;
        var descripcion = document.getElementById('descripcion').value;
        var color = document.getElementById('color').value;


        var urlActual = window.location.href;
        axios.post(urlActual, {
                numero: numero,
                nombre: nombre,
                capacidad: capacidad,
                descripcion: descripcion,
                estados_id: estado,
                precio: precio,
                precio_promocion: precio_promocion,
                color: color
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
@stop