@extends('admin_panel.index')

@section('content')
<form class="form-group" method="POST" action="/materiaPrima/{{$materiaPrima->id}}" enctype="multipart/form-data">
    @method('PUT')
    @csrf  
    @include('materiaPrima.form')
     <br>
     
     <button type="submit" class="btn btn-primary" >Actualizar</button>

</form>

    {{-- Boton para eliminar --}}
<form action="/materiaPrima/{{$materiaPrima->id}}" class="form-group" method="POST">
         
  @method('DELETE')
  @csrf   
        <button class="btn btn-danger" type="submit">Eliminar</button>

</form>
{{-- Finaliza el codigo para eliminar --}}
      

@endsection
    @push('scripts')
    <script>
            $(document).ready(function(){
              $('.select2').select2();
            };
          </script>
            
      @endpush