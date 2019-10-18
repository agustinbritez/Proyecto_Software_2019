@extends('layouts.pdf2')


@section('content')
<div class="row" style="margin-bottom: 5px">
    <h5 class="text-center"><strong><u style="color:black"> Reporte de Movimientos</u></strong></h5>
</div>

<div style="margin-bottom: 5px"><strong> Filtros Aplicados: </strong> </div>
<div style="margin-bottom: 5px">Numero de movimiento: {{$filtro_numero_movimiento ?? 'No aplicado'}}.</div>
<div style="margin-bottom: 5px">Precio Unitario Minimo: {{$filtro_precio_unitario_minimo?? 'No aplicado' }}.</div>
<div style="margin-bottom: 5px">Precio Unitario Maximo: {{$filtro_precio_unitario_maximo?? 'No aplicado' }}.</div>
<div style="margin-bottom: 5px">Fecha Desde: {{$filtro_fecha_desde ?? 'No aplicado' }}.</div>
<div style="margin-bottom: 5px">Fecha Hasta: {{$filtro_fecha_hasta ?? 'No aplicado' }}.</div>



{{-- <div> <h5>Lista de Materias Primas</h5></div> --}}
<br>
<div class="table" style="font-family: Arial, Helvetica, sans-serif;">

    <table class="table table-bordered">
        <thead style="background-color:white ; color:black;">
            <tr>
                <th>ID</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Fecha</th>


            </tr>
        </thead>
        <tbody style="background-color:white ; color:black;">
            @if (sizeof($movimientos)>0)

            @foreach ($movimientos as $movimiento)
            <tr style="text-align: right">

                <td>{{$movimiento->id}} </td>


                <td>{{$movimiento->precioUnitario}} </td>
                <td>{{$movimiento->cantidad}} </td>
                {{-- <td >{{$movimiento->getFechaMovimiento()}} </td> --}}
                <td>{{$movimiento->fecha}} </td>



            </tr>
            @endforeach
            @endif
        </tbody>


    </table>
</div>

@section('cantidad')
{{sizeof($movimientos)}}
@endsection
@stop