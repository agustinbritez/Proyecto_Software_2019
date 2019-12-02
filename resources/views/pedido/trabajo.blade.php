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
                    <form action="{{route('pedido.filtrarTrabajo')}}" method="GET" enctype="multipart/form-data">
                        @csrf

                        <hr>
                        <div class="row">



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

                            <div class="form-group col">
                                <label>Fecha Desde</label>
                                <input type="date" id="min" name="desde" value="" class="form-control">
                            </div>
                            <div class="form-group col">
                                <label>Fecha Hasta</label>
                                <input type="date" id="max" name="hasta" value="{{$hasta ?? ''}}" class="form-control">
                            </div>
                            <div class="form-group col">
                                <label>Ordenar Primero Por Pedido </label>
                                <select class="select2" name="filtro_pedido" id="filtro_pedido"
                                    data-placeholder="Seleccione Un Modelo" style="width: 100%;">
                                    {{-- <option value="" selected>Cualquiera</option> --}}
                                    <option value="-1" selected>Cualquiera</option>
                                    <option value="0">Mas Antiguo</option>
                                    <option value="1">Mas Nuevo</option>

                                </select>
                            </div>
                        </div>


                </div>
                <div class="card-footer text-muted">
                    <div class="text-center">
                        <button type="submit" name="filtrar" id="filtrar"
                            class="btn btn-success btn-sm">Filtrar</button>
                        <button type="button" name="reiniciar" id="reiniciar" class="btn btn-info btn-sm">Reiniciar
                            Tabla</button>
                    </div>
                </div>
                </form>
            </div>

            <div class="card text-left">


                <div class="card-header">
                    <div class="row justify-content-between">
                        <h3>Lista de Productos a realizar</h3>

                        <form action="{{ route('pedido.ordenamientoInteligente' ) }}"> <button type="submit"
                                class="btn btn-primary ">Optimizacion</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">

                        @if ($detallesOrdenados ?? false)
                        @foreach ($detallesOrdenados as $detallex)
                        @if ($detallex->getEstadoFinal()->id != $detallex->estado->id)
                        <div class="form-group">
                            <div class="col">
                                <div class="card" style="width: 18rem;">
                                    <img src="{{ asset('/imagenes/modelos/'.$detallex->producto->modelo->imagenPrincipal) }}"
                                        class="card-img-top" alt="..." height="250 px">
                                    <div class="card-body">
                                        <div class="text-center">

                                            <h5 class="text-orange">{{$detallex->producto->modelo->nombre}}</h5>
                                            <p>{{'Numero de pedido: '. $detallex->pedido->id}}</p>
                                            <p>Fecha Pago:{{' '.$detallex->pedido->getFechaPago()}}
                                            </p>
                                            <p>Cantidad imagenes:{{' '.$detallex->producto->cantidadImagenes()}}
                                            </p>
                                            <p><span class="badge badge-info ">{{$detallex->estado->nombre ?? 'Sin Estado'}}
                                                </span></p>
                                        </div>
                                        <div class="text-center">
                                            {{-- botones --}}
                                            <div>
                                                <form action="{{ route('detallePedido.show', $detallex->id) }}">
                                                    <button type="submit"
                                                        class="edit btn btn-outline-primary btn-sm">Ver
                                                        Producto</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endif


                        @endforeach
                        @else
                        @foreach ($pedidos as $pedido)
                        @foreach ($pedido->detallePedidos as $detallePedido)

                        @if ($detallePedido->getEstadoFinal()->id != $detallePedido->estado->id)


                        <div class="form-group">
                            <div class="col">
                                <div class="card" style="width: 18rem;">
                                    <img src="{{ asset('/imagenes/modelos/'.$detallePedido->producto->modelo->imagenPrincipal) }}"
                                        class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <div class="text-center">

                                            <h5 class="text-orange">{{$detallePedido->producto->modelo->nombre}}</h5>
                                            <p>{{'Numero de pedido: '. $pedido->id}}</p>
                                            <p>Fecha Pago:{{' '.$detallePedido->pedido->getFechaPago() }}
                                            </p>
                                            <p>Cantidad imagenes:{{' '.$detallePedido->producto->cantidadImagenes()}}
                                            </p>
                                            <p><span class="badge badge-info ">{{$detallePedido->estado->nombre ?? 'Sin Estado'}}
                                                </span></p>
                                        </div>
                                        <div class="text-center">
                                            {{-- botones --}}
                                            <div>
                                                <form action="{{ route('detallePedido.show', $detallePedido->id) }}">
                                                    <button type="submit"
                                                        class="edit btn btn-outline-primary btn-sm">Ver
                                                        Producto</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                        @endif

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
    $('#min').val('{{$desde ?? ''}}');
   
</script>

@endpush