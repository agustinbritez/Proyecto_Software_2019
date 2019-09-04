@extends('admin_panel.index')


@section('content')
    <p>Lista de Materias Primas</p>
    <div class="list-group">
    @foreach ($materiasPrimas as $materia)
    
    <div class="row align-items-start">
            <div class="col"><a href="materiaPrima/{{$materia->id}}" class="list-group-item list-group-item-action">{{$materia->nombre}}</a>&nbsp;</div>
            <div class=""><a href="materiaPrima/{{$materia->id}}/edit" class="btn btn-primary">Modificar</a>&nbsp;</div>
            <div class=""><a href="#" class="btn btn-danger">Eliminar</a></div>
          </div>
    @endforeach
    </div> 
@endsection