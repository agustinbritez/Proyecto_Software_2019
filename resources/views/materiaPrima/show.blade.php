@extends('layouts.app')

@section('head','Materia Prima ')

@section('contenidoCentral')
<form>
      

        <div class="form-row"> 
                <div class="col- float-left">
                  <label for="inputEmail4">Nombre:</label>
                   
                    
                </div>
                <div class="col-8 float-left">
                <input disabled value="{{$materiaPrima->name}}" class="form-control " id="inputEmail4" placeholder="Nombre de Materia Prima">

                </div>
              </div>

        <button type="submit" class="btn btn-primary">Volver</button>
</form>
        
  
  

@endsection