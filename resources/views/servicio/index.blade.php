@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Servicios</h1>
@stop

@section('content')
<div class="container">
<a href="servicios/create" class="btn btn-primary">CREAR</a>

<div class="table-responsive-sm">
<table id="servicios" class="table mt-4" style="width: 100%">
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
        
         
        <form action="{{ route ('servicios.destroy',$servicio->id)}}" class="form-eliminar" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalEditar{{$servicio->id}}">
            Editar 
          </button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>  

        <!-- Modal -->
          <div class="modal fade"id="modalEditar{{$servicio->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Editar Servicio</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="/servicios/{{$servicio->id}}"   enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                  <div class="mb-3">
                    <label for="" class="form-label">Nombre</label>
                    <input id="codigo" name="nombre" type="text" value="{{$servicio->nombre}}" class="form-control" tabindex="1">    
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Descripción</label>
                    <input id="descripcion" name="descripcion" value="{{$servicio->descripcion}}" type="text" class="form-control" tabindex="2">
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Imagen</label>
                    <input type="file" id="imagen" name="imagen" >
                  </div>

                  <div  class ="mb-3 mt-3" id="imagenPreview"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </form>
              </div>
            </div>
          </div>

        </td>        
    </tr>
    @endforeach
  </tbody>
</table>

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
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if ( session()->has('Result'))

<script>
    $(function(){
        toastr.{{ session('Result')['status'] }}('{{session('Result')['content'] }}')
    });

    
</script>
@endif


<script>
    $(document).ready(function() {

      $('.form-eliminar').submit(function(e){
      e.preventDefault();
      Swal.fire({
      title: '¿Estás seguro?',
      text: "Este servicio se eliminara definitivamente",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar!',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
      this.submit();
      }
    })
})

  function filePreview(input){
    if(input.files && input.files[0]){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#imagenPreview').html("<img width=600 class='img-fluid' src='"+e.target.result+"' />");
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $('#imagen').change(function(){
    filePreview(this);
  })

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




