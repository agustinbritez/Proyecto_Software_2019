@extends('admin_panel.index')

@section('content')
<div class="container-fluid">

    
    <form class="form-group" method="POST" action="/materiaPrima/{{$materiaPrima->id}}" enctype="multipart/form-data">
    @method('PUT')
    @csrf  
    @include('materiaPrima.form')
     <br>
 
         <button type="submit" class="btn btn-primary" >Actualizar</button>
       
         {{-- Boton para eliminar --}}
         <a  href="{{route('materiaPrima.destroy',$materiaPrima)}}" onclick="return confirm('¿Seguro que desea eliminarlo?')"> 
            <span  class="btn btn-danger " >
                    <span class="fas fa-tresh-alt"> Borrar</span>
            </span>
    </a>
     {{-- Finaliza el codigo para eliminar --}}
    </form>


</div>

@endsection