@extends('adminlte::page')

@section('title', 'Cliente | Editar')
@php
@endphp
@section('content_header')
@stop

@section('content')
<form>
    <div class="modal-body">
        <div class="col">
            <label for="nombre">Nombre del cliente</label>
            <input type="text" value="{{$cliente->nombre}}" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo del cliente" />
            <label for="pais_id">Pais</label>
            <select data-live-search="true" class="selectpicker input-group-text form-control border border-secondary" name="pais_id" id="pais_id">
                @foreach ($paises as $pais)
                @if($pais->id==$cliente->pais_id)
                <option selected value="{{ $pais->id}}">{{ $pais->nombre }}</option>
                @else
                <option value="{{ $pais->id}}">{{ $pais->nombre }}</option>
                @endif
                @endforeach
            </select>
            <label for="telefono">Numero de telefono</label>
            <input type="text" value="{{$cliente->telefono}}" class="form-control" id="telefono" name="telefono" placeholder="Numero de telefono" />
            <label for="correo">Correo</label>
            <input type="email" value="{{$cliente->correo}}" class="form-control" id="correo" name="correo" placeholder="Correo electronico" />
            <label for="telefono">Fecha de registro</label>
            <input readonly type="text" value="{{$cliente->registro}}" class="form-control" id="registro" name="registro" placeholder="Numero de telefono" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="actualizar('{{$cliente->id}}')" class="btn btn-primary">actualizar</button>
    </div>
</form>
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
    function actualizar(id) {
        var nombre = document.getElementById('nombre').value;
        var telefono = document.getElementById('telefono').value;
        var correo = document.getElementById('correo').value;
        var pais_id = document.getElementById('pais_id').value;

        const Estado = {
            nombre: nombre,
            telefono: telefono,
            correo: correo,
            pais_id: pais_id,
            id: id
        }
        console.log(Estado)
        var urlActual = window.location.href;
        var nuevaUrl = urlActual.replace('/' + id + '/edit', '');
        axios.patch(urlActual, Estado)
            .then(response => {
                console.log(response)
                Swal.fire({
                    title: "Actualizado",
                    text: "Registro Actualizado",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    axios.get(nuevaUrl).then(function(response) {
                            window.location.href = nuevaUrl;
                        })
                        .catch(function(error) {});
                });
            })
            .catch(function(error) {
                console.error(error.request.response)
                Swal.fire({
                    title: "Error",
                    text: "Registro no actualizado " + error,
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    window.location.href = nuevaUrl;
                });
            });
    }
</script>
@stop