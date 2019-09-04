@extends('layouts.app')

@section('head','Editar ')

@section('contenidoCentral')
<form class="form-group" method="POST" action="/materiaPrima/{{$materiaPrima->id}}" enctype="multipart/form-data">
    @method('PUT')
    @csrf  
    <div class="form-group">
      <label for="">Nombre:</label>   
      <input  value="{{$materiaPrima->nombre}}" class="form-control "  placeholder="Nombre de Materia Prima" name="nombre">
    </div>
    <div class="form-group">
      <label for="">Medida:</label>   
      <input  value="{{$materiaPrima->medida}}" class="form-control "  placeholder="Medida" name="medida">
    </div>
     <br>
     <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
        
  
  

@endsection