@extends('layouts.pdf2')


@section('content')
<div class="row" style="margin-bottom: 5px">
    <h5 class="text-center"><strong><u style="color:black"> Reporte de Auditoria</u></strong></h5>
</div>


<div style="margin-bottom: 5px"><strong> Filtros Aplicados: </strong> </div>
<div style="margin-bottom: 5px">Tabla: <strong>{{' '}}{{$filtro_tabla?? 'No aplicado'}}</strong>.</div>
@if ($usuario->name !=null)
<div style="margin-bottom: 5px">Usuario:
    <strong>{{' id: '.$usuario->id .' - email: '.$usuario->email ?? ' No aplicado' }}</strong>.</div>
@else
<div style="margin-bottom: 5px">Usuario: <strong>{{ ' No aplicado' }}</strong>.</div>
@endif
<div style="margin-bottom: 5px">Objeto: <strong>{{' '}}{{$filtro_objeto ?? ' No aplicado'}}</strong>.</div>
<div style="margin-bottom: 5px">Operacion: <strong>{{' '}}{{$filtro_operacion ?? ' No aplicado'}}</strong>.</div>
<div style="margin-bottom: 5px">Creado Desde: <strong>{{' '}}{{$desde ?? ' No aplicado'}}</strong>.</div>
<div style="margin-bottom: 5px">Creado Hasta: <strong>{{' '}}{{$hasta ?? ' No aplicado'}}</strong>.</div>


{{-- <div> <h5>Lista de Materias Primas</h5></div> --}}
<hr>
<div style="margin-bottom: 5px">
    <p>Cantidad Total de Registrados:<strong> {{' '}}{{($cantidadRegistros)}}
        </strong> </p>.
</div>
<div class="table" style="font-family: Arial, Helvetica, sans-serif;">


    <table class='table table-bordered table-striped table-hover' id='data-table'>
        {{-- <thead style="background-color:white ; color:black;"> --}}
        <thead style="background-color:white ; color:black;">
            <tr>
                <th>ID Objeto</th>
                <th>Tabla</th>
                <th>ID Usuario</th>
                <th>Operacion</th>
                <th>Fecha</th>



            </tr>
        </thead>
        <tbody style="background-color:white ; color:black;">
            @foreach ($auditorias as $auditoria)
            <tr>
                <td>{{$auditoria->auditable_id}}</td>
                <td>{{ str_replace(['App\\', '$', ' '], '', $auditoria->auditable_type)}}</td>
                <td>{{$auditoria->user_id   }}</td>
                <td>{{$auditoria->event }}</td>
                <td>{{$auditoria->created_at}}</td>
            </tr>
            @endforeach


        </tbody>



    </table>
</div>


@stop