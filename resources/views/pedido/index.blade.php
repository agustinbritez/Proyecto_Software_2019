@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col">
            <div class="card text-left">

                <div class="card-header">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                    <h3>Filtro de Pedidos</h3>
                </div>


                <div class="card-body">
                    <form action="{{route('pdf.materiaPrima')}}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div align="right">

                            <button type="submit" class="btn  btn-success  btn-flat btn-sm">Reporte Pedidos</button>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="form-group col">
                                <label>Nombre : </label>
                                <input class="form-control" type="text" name="filtro_nombre" id="filtro_nombre"
                                    data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
                            </div>
                            <div class="form-group col ">
                                <label class="control-label">Cantidad : </label>

                                <input type="text" class="form-control text-left" name="filtro_cantidad"
                                    id="filtro_cantidad" placeholder="Cantidad de pedido prima" data-mask
                                    data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">

                            </div>
                            <div class="form-group col">
                                <label>Modelo : </label>
                                <select class="select2" name="filtro_modelo" id="filtro_modelo"
                                    data-placeholder="Seleccione Un Modelo" style="width: 100%;">
                                    {{-- <option value="" selected>Cualquiera</option> --}}
                                    <option value="-1">Cualquiera</option>
                                    @if(sizeof($modelos)>0)
                                    @foreach ($modelos as $modelo)
                                    <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
                                    @endforeach

                                    @endif
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="card-footer text-muted">
                    <div class="text-center">
                        <button type="button" name="filtrar" id="filtrar"
                            class="btn btn-success btn-sm">Filtrar</button>
                        <button type="button" name="reiniciar" id="reiniciar" class="btn btn-info btn-sm">Reiniciar
                            Tabla</button>
                    </div>
                </div>

            </div>

            <div class="card text-left">


                <div class="card-header">
                    <h3>Lista de Pedidos</h3>
                </div>
                <div class="card-body">

                    <div align="left">
                        <button type="button" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear Nuevo Pedido </button>

                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID</th>
                                    <th>Cantidad de Productos</th>
                                    <th>Precio Total</th>
                                    <th>Fecha de Pago</th>
                                    <th>Estado</th>
                                    <th>Fecha de Cambio de Estado</th>
                                    <th>Terminado</th>
                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($pedidos)>0)

                                @foreach ($pedidos as $pedido)
                                <input type="hidden" name="" id="{{$cantidadProductos=0}}">
                                <tr>
                                    <td>{{$pedido->id}} </td>
                                    <td align="right">
                                        @if (!$pedido->detallePedidos->isEmpty())
                                        @foreach ($pedido->detallePedidos as $detalle)
                                        <input type="hidden" name="" id="{{$cantidadProductos+=$detalle->cantidad}}">
                                        @endforeach
                                        {{$cantidadProductos}}
                                        @else
                                        0
                                        @endif

                                    </td>
                                    <td align="right">${{$pedido->precio ?? 'No pagado'}} </td>
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
                                        <span
                                            class="badge badge-success">{{$pedido->estado->nombre ?? 'Sin Estado'}}</span>
                                        @else

                                        @if ($pedido->estado->id == $pedido->flujoTrabajo->getEstadoFinal()->id)
                                        <span
                                            class="badge badge-danger">{{$pedido->estado->nombre ?? 'Sin Estado'}}</span>
                                        @else
                                        <span
                                            class="badge badge-info">{{$pedido->estado->nombre ?? 'Sin Estado'}}</span>
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


                                    <th>
                                        <form action="{{route('detallePedido.index',$pedido->id)}}" method="GET">

                                            <button type="submit" name="edit" id="{{$pedido->id}}"
                                                class="btn btn-outline-primary btn-sm">Ver Detalles</button>
                                        </form>
                                        {{-- &nbsp;&nbsp;
                                        <button type="button" name="delete" id="{{$pedido->id}}"
                                        class="delete btn btn-outline-danger btn-sm">Eliminar</button> --}}
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
                                    <th>&nbsp; </th>


                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    {{-- 2 days ago --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@section('htmlFinal')
{{-- @include('pedido.modalIndex') --}}
@endsection


@push('scripts')
<script>
    var table= $('#data-table').DataTable({
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
            
        }
    });
  
   
</script>

@endpush