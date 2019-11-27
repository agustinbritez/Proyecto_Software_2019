@extends('admin_panel.index')

@section('content')
<br>

<div class="card">
    <div class="row justify-content-center pb-0 ">
        <h4 class="text-primary"
            style=" font-size: 200px; font-weight: 600; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">
            404</h4>
        <br>
    </div>
    <div class="row justify-content-center">
        <h2>
            Parece que te has perdido!</h2>
    </div>

    <div class="row justify-content-center">
        <h4 class="text-gray">
            La pagina que estas buscando no existe o fue movida.</h4>
    </div>
    <br>
    <div class="card-body">
        <div class="row justify-content-center">
            <a href="{{route('home')}}" class="btn btn-pill btn-sm btn-outline-primary pl-3 pr-3">
                <i class="fal fa-home pr-1"></i>
                Inicio
            </a>
            <a href="{{URL::previous()}}" class="btn btn-pill btn-sm btn-outline-primary pl-3 pr-3">
                <i class="fal fa-arrow-left pr-1"></i>
                Volver
            </a>

        </div>
    </div>
</div>

@endsection