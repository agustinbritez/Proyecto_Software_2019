@extends('layouts.pdf2')


@section('content')
<div class="row" style="margin-bottom: 5px">
    <h5 class="text-center"><strong><u style="color:black"> Reporte de Auditoria</u></strong></h5>
</div>


<div style="margin-bottom: 5px"><strong> Filtros Aplicados: </strong> </div>

<div style="margin-bottom: 5px">Tabla:
    <strong>{{' '}}{{str_replace(['App\\', '$', ' '], '', $auditorias[0]->auditable_type)}}</strong>.</div>
<div style="margin-bottom: 5px">ID Objeto Auditado: <strong>{{' '}}{{$auditorias[0]->auditable_id}}</strong>.</div>




{{-- <div> <h5>Lista de Materias Primas</h5></div> --}}
<hr>
<div style="margin-bottom: 5px">
    <p>Cantidad Total de Registrados:<strong> {{' '}}{{($cantidadRegistros)}}
        </strong> </p>.
</div>

@foreach ($auditorias as $auditoria)


<table class="table table-bordered  ">
    <thead>
        <tr class="thead-light  ">
            <th>
                <p>ID{{': '.$auditoria->id}}</p>
            </th>
            <th>
                <p>Usuario{{': '}}{{$auditoria->user->apellido ?? 'Sin Apellido'}}
                    {{', '}}{{$auditoria->user->name ?? 'Sin Nombre'}}</p>
            </th>
            <th>
                <p>Operacion{{': '. strtoupper($auditoria->event) }}</p>
            </th>
            <th>
                <p>Fecha y Hora{{': '.$auditoria->created_at->format('d/m/Y - H:i:s')}}</p>
            </th>
        </tr>
    </thead>
    <tbody class="">
        <tr class="thead-light">
            <th colspan="2">Campos</th>
            <th>Datos Nuevos</th>
            <th>Datos Antiguos</th>
        </tr>
        @foreach ($auditoria->getModified() as $attribute => $modified)
        <tr>
            <td colspan="2">
                {{$attribute}}
            </td>

            <td>
                @if(!empty($auditoria->new_values))
                {{$auditoria->new_values[$attribute]}}
                @else
                -
                @endif
            </td>

            <td>
                @if(!empty($auditoria->old_values))
                {{$auditoria->old_values[$attribute]}}
                @else
                -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

</div>
@endforeach


@stop