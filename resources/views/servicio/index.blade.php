@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Servicios</h1>
@stop

@section('content')
<div class="container">
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
         <!--<form action="{{ route('servicios.destroy',$servicio->id) }}" method="POST">
          <a href="/servicios/{{$servicio->id}}/edit" class="btn btn-info">Editar</a> 
         -->
         <button type="button" class="btn btn-info" data-toggle="modal" data-id="{{ $servicio->id }}" data-target="#modalEditar">
          Editar 
        </button>
              @csrf
              
              @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
                  
        </td>        
    </tr>
    @endforeach
  </tbody>
</table>
</div>




<!-- Modal -->
<div class="modal fade"id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" value="{{ $servicio->nombre}}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>







@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('/css/toastr.css') }}" rel="stylesheet">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/js/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
@if ( session()->has('Result'))

<script>
    $(function(){
        toastr.{{ session('Result')['status'] }}('{{session('Result')['content'] }}')
    });
</script>
@endif


<script>
    $(document).ready(function() {
    $('#servicios').DataTable({
      "lengthMenu": [[5, 10, 50, -1 ], [5, 10, 50, "Todos"]],
      "language": {
            "lengthMenu": "Mostrar _MENU_ registros ",
            "zeroRecords": "Nada encontrado",
            "info": "Mostrando la página _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(Filtrado de _MAX_ registros totales)",
            "search": "Buscar",
            'paginate':{
              'next':'Siguiente',
              'previous':'Anterior'
            }
        }
    });
} );
</script>
@stop




