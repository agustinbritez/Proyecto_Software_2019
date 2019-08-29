@extends('layouts.app')

@section('head','Materias Primas ')

@section('contenidoCentral')
    <p>Lista de Materias Primas</p>
    <div class="list-group">
    @foreach ($materiasPrimas as $materia)
    <a href="materiaPrima/{{$materia->id}}" class="list-group-item list-group-item-action">{{$materia->name}}</a>
    @endforeach
    </div> 
@endsection