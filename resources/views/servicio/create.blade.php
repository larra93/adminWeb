@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Nuevo Servicio</h1>
@stop

@section('content')
<h2>CREAR REGISTROS</h2>
@if($message = Session::get('ErrorInsert'))

<div class="col-12 alert alert-danger alert-dismissable fade show" role="alert">
  <h5>Errores:</h5>
<ul>
  @foreach($errors->all() as $error)
<li>{{ $error }}</li>

@endforeach
</ul>  
</div>

@endif
<form action="/servicios"  enctype="multipart/form-data" method="POST">
    @csrf
  <div class="mb-3">
    <label for="" class="form-label">Nombre</label>
    <input id="codigo" name="nombre" type="text" class="form-control" tabindex="1">    
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Descripción</label>
    <input id="descripcion" name="descripcion" type="text" class="form-control" tabindex="2">
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Imagen</label>
    <input type="file" name="imagen" >
  </div>
 
  <a href="/servicios" class="btn btn-secondary" tabindex="5">Cancelar</a>
  <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>
</form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop



