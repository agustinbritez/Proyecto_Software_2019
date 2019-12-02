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
                    <h3>Filtro de Detalle de Pedidos</h3>
                </div>


                <div class="card-body">
                    <form action="{{route('pdf.materiaPrima')}}" method="GET" enctype="multipart/form-data">
                        @csrf

                        <hr>
                        <div class="row">


                            <div class="form-group col ">
                                <label class="control-label">Cantidad : </label>

                                <input type="text" class="form-control text-left" name="filtro_cantidad"
                                    id="filtro_cantidad" placeholder="Cantidad de pedido prima" data-mask
                                    data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">
                            </div>

                            <div class="form-group col ">
                                <label class="control-label">Verificado : </label>

                                <select class="select2" name="filtro_verificar" id="filtro_verificar"
                                    data-placeholder="Seleccione Un Modelo" style="width: 100%;">


                                    <option value="0">Sin Verificar</option>
                                    <option value="1">Verificado</option>

                                </select>
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
                    <h3>Informacion del Usuario</h3>

                </div>

                <div class="card-body">
                    <div>
                        <div class="row">
                            <h4>
                                <label for="" style="font-weight: normal;">Usuario:
                                    {{' '.$pedido->user->name.' '.$pedido->user->appellido}}</label>


                            </h4>
                        </div>
                        <div class="row">
                            <h4>
                                <label for="" style="font-weight: normal;">Correo: {{' '.$pedido->user->email}}</label>
                            </h4>
                        </div>
                        @if (!$pedido->user->direccionEnvios->isEmpty())
                        <div class="row">
                            <h4>
                                <label for="" style="font-weight: normal;">Direccion Envio:
                                    {{$pedido->user->direccionPredeterminada()->obtenerDireccion()}}</label>
                            </h4>
                        </div>
                        <div class="row">
                            <h4>
                                <label for="" style="font-weight: normal;">Codigo Postal:
                                    {{$pedido->user->direccionPredeterminada()->obtenerCodigoPostal()}}</label>

                            </h4>
                        </div>
                        @else

                        @endif
                    </div>


                    {{-- <div align="left">
                        <button type="button" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear Nuevo Pedido </button>

                    </div> --}}
                    <hr>
                    <h3>Lista de Detalle de Pedido</h3>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Cantidad </th>
                                    <th>Precio Total</th>
                                    <th>Estado</th>
                                    <th>Verificado</th>
                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($detallePedidos)>0)

                                @foreach ($detallePedidos as $detallePedido)
                                <input type="hidden" name="" id="{{$cantidadProductos=0}}">
                                <tr>
                                    <td>{{$detallePedido->id}} </td>
                                    <td>{{$detallePedido->producto->modelo->nombre}} </td>
                                    <td align="right">{{$detallePedido->cantidad ?? 'Sin cantidad'}} </td>
                                    @if ($detallePedido->cantidad!=null)

                                    <td align="right">
                                        ${{$detallePedido->cantidad * $detallePedido->producto->modelo->precioUnitario}}
                                    </td>
                                    @else
                                    <td align="right">${{ $detallePedido->producto->modelo->precioUnitario}}
                                    </td>
                                    @endif
                                    <td>
                                        @if ($detallePedido->estado!=null)

                                        @if(($detallePedido->producto->modelo->flujoTrabajo->getEstadoInicial()!=null)
                                        &&($detallePedido->producto->modelo->flujoTrabajo->getEstadoFinal()!=null))



                                        @if ($detallePedido->estado->id ==
                                        $detallePedido->producto->modelo->flujoTrabajo->getEstadoInicial()->id)
                                        <span
                                            class="badge badge-success">{{$detallePedido->estado->nombre ?? 'Sin Estado'}}</span>
                                        @else

                                        @if ($detallePedido->estado->id ==
                                        $detallePedido->producto->modelo->flujoTrabajo->getEstadoFinal()->id)
                                        <span
                                            class="badge badge-danger">{{$detallePedido->estado->nombre ?? 'Sin Estado'}}</span>
                                        @else
                                        <span
                                            class="badge badge-info">{{$detallePedido->estado->nombre ?? 'Sin Estado'}}</span>
                                        @endif
                                        @endif

                                        @else

                                        <span class="badge badge-info">{{'Sin Estado'}}</span>
                                        @endif

                                        @else
                                        <span class="badge badge-info">{{'Sin Estado'}}</span>
                                        @endif


                                    </td>


                                    <td>
                                        @if ($detallePedido->verificado!=null )
                                        @if ($detallePedido->verificado)
                                        Verificado
                                        @else
                                        Sin Verificar

                                        @endif
                                        @else
                                        Sin Verificar
                                        @endif
                                    </td>


                                    <td>
                                        @if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin'))


                                        <form action="{{route('detallePedido.show',$detallePedido->id)}}">

                                            <button type="submit" name="edit" id="{{$detallePedido->id}}"
                                                class="edit btn btn-outline-primary btn-sm">Ver
                                                Producto</button>
                                        </form>
                                        @endif
                                        {{-- &nbsp;&nbsp;
                                        <button type="button" name="delete" id="{{$detallePedido->id}}"
                                        class="delete btn btn-outline-danger btn-sm">Eliminar
                                        </button> --}}

                                    </td>


                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Cantidad </th>
                                    <th>Precio Total</th>
                                    <th>Estado</th>
                                    <th>Verificado</th>
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
@if ($pedido!=null)

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmacion</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;" id="tituloConfirm">¿Esta seguro que desea finalizar el pedido?</h4>
            </div>
            <div class="modal-footer">
                <form id="formConfirm" action="{{ route('pedido.terminarPedido', $pedido->id) }}" method="POST">
                    @csrf
                    {{-- Paso el id de la materia  aborrar en materia_delete--}}
                    <input type="hidden" name="materia_delete" id="materia_delete">
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-primary">OK</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endif
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
    $('.finalizar').click(function(){

        $('#confirmModal').modal('show');
    });
  
   
</script>

@endpush