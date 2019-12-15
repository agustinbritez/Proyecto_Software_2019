@extends('layouts.pdf2')


@section('content')
<div class="row" style="margin-bottom: 5px">
    <h5 class="text-center"><strong><u style="color:black"> Reporte de Materia Primas</u></strong></h5>
</div>

<div style="margin-bottom: 5px"><strong> Filtros Aplicados: </strong> </div>
<div style="margin-bottom: 5px">Nombre: <strong> {{' '}} <strong>{{$filtro_nombre ?? ' No aplicado '}}</strong>.</div>
<div style="margin-bottom: 5px">Cantidad:{{' '}} <strong>{{$filtro_cantidad ?? ' No aplicado '}}</strong>.</div>
<div style="margin-bottom: 5px">Sotck Minimo:{{' '}} <strong>{{$filtro_minimo ?? ' No aplicado '}}</strong>.</div>
<div style="margin-bottom: 5px">Opcion de Producto:{{' '}}
    <strong>{{$filtro_modelo->nombre ?? ' No aplicado '}}</strong>.</div>
<hr>
<div style="margin-bottom: 5px">
    <p>Cantidad Total de Registrados:<strong>{{' '}} {{($cantidadRegistros)}}
        </strong> </p>.
</div>

{{-- <div> <h5>Lista de Materias Primas</h5></div> --}}

<div class="table" style="font-family: Arial, Helvetica, sans-serif;">

    <table class="table table-bordered">
        <thead>
            <tr style="line-height: 14px; font-size: 14px; background: lightgrey">
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Stock Minimo</th>
                <th>Medida </th>
                <th>Modelos </th>
            </tr>
        </thead>

        <tbody>

            @foreach ($materiaPrimas as $materia)
            <tr>
                <td align="right">{{$materia->id}}</td>
                <td>{{$materia->nombre}}</td>
                <td align="right">{{number_format($materia->precioUnitario,2) }}</td>
                <td align="right">{{number_format($materia->cantidad)}}</td>
                <td align="right">{{number_format($materia->stockMinimo)}}</td>
                <td >{{$materia->medida->nombre}}</td>
                <td>
                    @foreach ($materia->modelos as $key=>$modelo)
                    <span><strong> {{$modelo->nombre}}</strong> </span>&nbsp;&nbsp;
                    @endforeach
                </td>

            </tr>
            @endforeach
        </tbody>
        <tbody>
        </tbody>

    </table>
</div>

@section('cantidad')
{{sizeof($materiaPrimas)}}
@endsection
@stop