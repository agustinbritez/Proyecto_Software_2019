@extends('layouts.app')

@section('head','Materia Prima Creacion')

@section('contenidoCentral')
    <form class="form-group" method="POST" action="/materiaPrima">
        @csrf {{-- Se utiliza para evitar injecciones  --}}
            <div class="form-group">
                    <label for="">Nombre</label>
                    <input  type="text" name="name" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    


@endsection
