@extends('layouts.app')

@section('head','Materia Prima ')

@section('contenidoCentral')
<form method="POST">
      

        <div class="form-row"> 
                <label for="inputEmail4">Nombre:</label>   
                <input disabled value="{{$materiaPrima->nombre}}" class="form-control " id="" placeholder="Nombre de Materia Prima">
                <label for="inputEmail4">Medida:</label>   
                <input disabled value="{{$materiaPrima->medida}}" class="form-control " id="" placeholder="Nombre de Materia Prima">
                
        </div>

        
          <br>
          <a href="/materiaPrima/{{$materiaPrima->id}}/edit" class="btn btn-primary">Modificar</a> 
</form>
        
  
  

@endsection