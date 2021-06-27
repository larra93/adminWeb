
@extends('layouts.main')

@section('css')
    
<link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('contenido')
    
<a href="servicios/create" class="btn btn-primary">CREAR</a>


<table id="servicios" class="table table-striped shadow-lg mt-4" style="width: 100%">
  <thead class="bg-primary text-white">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nombre</th>
      <th scope="col">Descripción</th>
      <th scope="col">Imagen</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>    
    @foreach ($servicios as $servicio)
    <tr>
        <td>{{$servicio->id}}</td>
        <td>{{$servicio->nombre}}</td>
        <td>{{$servicio->descripcion}}</td>
        <td><img src="{{ asset('images/servicios/thumbs/'.$servicio->imagen) }}" width=100 > </td>
        <td>
         <form action="{{ route('servicios.destroy',$servicio->id) }}" method="POST">
          <a href="/servicios/{{$servicio->id}}/edit" class="btn btn-info">Editar</a>         
              @csrf
              @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
         </form>          
        </td>        
    </tr>
    @endforeach
  </tbody>
</table>

@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
    $('#servicios').DataTable();
} );
</script>

@endsection

@endsection