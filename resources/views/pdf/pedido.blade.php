@extends('layouts.pdf2')


@section('content')
<div class="row" style="margin-bottom: 5px">
    <h5 class="text-center"><strong><u style="color:black"> Reporte de Pedidos</u></strong></h5>
</div>




<div style="margin-bottom: 5px"><strong> Filtros Aplicados: </strong> </div>
<div style="margin-bottom: 5px"> Cantidad Pedidos Minimo: <strong>
        {{' '}}{{$cantidadMin == ''? ' No Aplicado ': number_format($cantidadMin)}}{{' '}}</strong>Maximo:
    <strong>{{' '}}{{$cantidadMax == ''? ' No Aplicado ': number_format($cantidadMax)}}.
    </strong></div>
<div style="margin-bottom: 5px">Precio Pedido Minimo:
    <strong>{{' '}}{{ $filtro_precioUnitarioMin == ''? ' No Aplicado ': number_format($filtro_precioUnitarioMin,2)}}{{' '}}</strong>Maximo:
    <strong>{{' '}}{{$filtro_precioUnitarioMax == ''? ' No Aplicado ': number_format($filtro_precioUnitarioMax,2)}}.</strong>
</div>

<div style="margin-bottom: 5px">Fecha Pago del Pedido Desde:
    <strong>
        {{' '}}{{$fechaPagoDesde=='' ? ' No Aplicado ':$fechaPagoDesde}}{{' '}}</strong>Hasta:
    <strong>{{' '}}{{$fechaPagoHasta=='' ? ' No Aplicado ':$fechaPagoHasta}}.</strong> </div>

<div style="margin-bottom: 5px">Fecha Cambio de esado Desde: <strong>
        {{' '}}{{$estadoDesde == '' ?' No Aplicado ' :$estadoDesde }}{{' '}}</strong>Hasta:
    <strong>{{' '}}{{ $estadoHasta == '' ?' No Aplicado ' :$estadoHasta}}.
    </strong></div>


<div style="margin-bottom: 5px">Terminado: <strong>{{' '}}{{$filtro_terminado ?? ' No aplicado '}}</strong>.</div>
<div style="margin-bottom: 5px">Estado: <strong>{{' '}}{{$filtro_estado ?? ' No aplicado '}}</strong>.</div>
<hr>
<div style="margin-bottom: 5px">
    <p>Cantidad Total de Registrados:<strong> {{($cantidadRegistros)}}
        </strong> </p>.
</div>




<div class="table" style="font-family: Arial, Helvetica, sans-serif;margin-bottom: 5px; margin-top: 5px;">


    <table class='table table-bordered '>
        <thead style="background-color:white ; color:black;">
            <tr>
                <th>ID</th>
                <th>Cantidad de Productos</th>
                <th>Precio Total</th>
                <th>Fecha de Pago</th>
                <th>Estado</th>
                <th>Fecha de Cambio de Estado</th>
                <th>Terminado</th>


            </tr>
        </thead>
        <tbody style="background-color:white ; color:black;">
            @if (sizeof($pedidos)>0)

            @foreach ($pedidos as $pedido)
            <tr>
                <td>{{$pedido->id}} </td>
                <td align="right">
                    {{number_format($pedido->getCantidadProductos())}}


                </td>
                <td align="right">{{number_format($pedido->precio,2) ?? 0}} </td>
                @if ($pedido->fechaPago!=null)
                <td>{{$pedido->getFechaPago() ?? 'No pagado' }} </td>

                @else

                <td>{{ 'No pagado' }} </td>
                @endif
                <td>
                    @if ($pedido->estado!=null)

                    @if (($pedido->flujoTrabajo->getEstadoInicial()!=null)
                    &&($pedido->flujoTrabajo->getEstadoFinal()!=null) )

                    @if ($pedido->estado->id == $pedido->flujoTrabajo->getEstadoInicial()->id)
                    <span class="badge badge-success">{{$pedido->estado->nombre ?? 'Sin Estado'}}</span>
                    @else

                    @if ($pedido->estado->id == $pedido->flujoTrabajo->getEstadoFinal()->id)
                    <span class="badge badge-danger">{{$pedido->estado->nombre ?? 'Sin Estado'}}</span>
                    @else
                    <span class="badge badge-info">{{$pedido->estado->nombre ?? 'Sin Estado'}}</span>
                    @endif
                    @endif

                    @else

                    <span class="badge badge-info">{{'Sin Estado'}}</span>
                    @endif

                    @else
                    <span class="badge badge-info">{{'Sin Estado'}}</span>
                    @endif


                </td>

                @if ($pedido->cambioEstado!=null)

                <td>{{$pedido->getCambioEstado()?? 'No pagado' }} </td>
                @else

                <td>{{'No pagado' }} </td>
                @endif
                <td>

                    @if ($pedido->terminado)
                    Si
                    @else
                    No
                    @endif


                </td>




            </tr>
            @endforeach
            @endif
        </tbody>

        <tfoot style="background-color:#ccc; color:white;">
            <tr>
                <th>ID</th>
                <th>Cantidad de Productos</th>
                <th>Precio Total</th>
                <th>Fecha de Pago</th>
                <th>Estado</th>
                <th>Fecha de Cambio de Estado</th>
                <th>Terminado</th>


            </tr>
        </tfoot>

    </table>
</div>



@stop