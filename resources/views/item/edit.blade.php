@extends('admin_panel.index')

@section('content')
<div class="container-fluid">

    
    <form class="form-group" method="POST" action="/item/{{$item->id}}" enctype="multipart/form-data">
    @method('PUT')
    @csrf  
    @include('item.form')
     <br>
 
         <button type="submit" class="btn btn-primary" >Actualizar</button>
       
         {{-- Boton para eliminar --}}
         <a  href="{{route('item.destroy',$item)}}" onclick="return confirm('¿Seguro que desea eliminarlo?')"> 
            <span  class="btn btn-danger " >
                    <span class="fas fa-tresh-alt"> Borrar</span>
            </span>
    </a>
     {{-- Finaliza el codigo para eliminar --}}
    </form>


</div>

@endsection