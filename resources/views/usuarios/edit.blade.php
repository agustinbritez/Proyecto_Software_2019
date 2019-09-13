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
<form action="{{route('materiaPrima.index')}}" class="form-group" method="POST">
         
  @method('DELETE')
  @csrf   
        <button class="btn btn-danger" type="submit">Eliminar</button>
</form>
{{-- Finaliza el codigo para eliminar --}}
@endsection