@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-left">

                <div class="card-header">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                    <h3>Filtro de Pedidos</h3>
                </div>


                <form action="{{route('pedido.filtrarMisPedidos')}}" method="GET" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">


                        <div class="row">

                            <div class="form-group col">
                                <label>Estado Actual : </label>
                                <select class="select2 form-control" name="filtro_estado" id="filtro_estado"
                                    data-placeholder="Seleccione Un Modelo">
                                    {{-- <option value="" selected>Cualquiera</option> --}}
                                    <option value="-1" selected>Cualquiera</option>
                                    @if(sizeof($estados)>0)
                                    @foreach ($estados as $estado)
                                    @if ($estado!=null)

                                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endif
                                    @endforeach

                                    @endif
                                </select>
                            </div>
                            <div class="form-group col">
                                <label>Producto : </label>
                                <select class="select2 form-control" name="filtro_modelo" id="filtro_modelo"
                                    data-placeholder="Seleccione Un Modelo">
                                    {{-- <option value="" selected>Cualquiera</option> --}}
                                    <option value="-1" selected>Cualquiera</option>
                                    @if(sizeof($modelos)>0)
                                    @foreach ($modelos as $modelo)
                                    @if ($modelo!=null)

                                    <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
                                    @endif
                                    @endforeach

                                    @endif
                                </select>
                            </div>

                            <div class="form-group col">
                                <label>Pagados Desde</label>
                                <input type="date" id="min" name="desde" value="" class="form-control">
                            </div>
                            <div class="form-group col">
                                <label>Pagados Hasta</label>
                                <input type="date" id="max" name="hasta" value="{{$hasta ?? ''}}" class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="text-center">
                            <button type="submit" name="filtrar" id="filtrar"
                                class="btn btn-success btn-sm">Filtrar</button>
                            <a type="button" href="{{ route('pedido.misPedidos') }}" name="reiniciar" id="reiniciar"
                                class="btn btn-info btn-sm">Reiniciar
                            </a>
                        </div>

                    </div>
                </form>
            </div>

            <div class="card text-left">


                <div class="card-header">
                    <h3>Lista de Pedidos</h3>
                </div>
                <div class="card-body">


                    <div class="accordion" id="accordionExample">
                        @foreach ($misPedidos as $pedido)

                        <div class="card">
                            <div class="card-header" id="heading_{{$pedido->id}}">
                                <h3 class="mb-0" data-toggle="collapse" data-target="#pedido_{{$pedido->id}}"
                                    aria-expanded="true" aria-controls="pedido_{{$pedido->id}}">
                                    <div class="row">
                                        <div class="col">
                                            <span class="badge badge-light">{{'Numero de Pedido: '.$pedido->id}} </span>
                                            @if ($pedido->estado->id == $pedido->flujoTrabajo->getEstadoInicial()->id )
                                            <span
                                                class="badge badge-success">{{$pedido->estado->nombre ?? 'Sin Estado'}}
                                            </span>
                                            @else
                                            @if (!is_null($pedido->pago_id))
                                            @if ($pedido->estado->id == $pedido->flujoTrabajo->getEstadoFinal()->id)
                                            <span class="badge badge-danger">{{$pedido->estado->nombre ?? 'Sin Estado'}}
                                            </span>
                                            @else
                                            <span class="badge badge-info">{{$pedido->estado->nombre ?? 'Sin Estado'}}
                                            </span>
                                            @endif

                                            @else
                                            <span
                                                class="badge badge-warning">{{$pedido->estado->nombre ?? 'Sin Estado'}}
                                            </span>
                                            @endif

                                            @endif


                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-flat btn-primary" type="button"
                                                data-toggle="collapse" data-target="#collapse_{{$pedido->id}}"
                                                aria-expanded="true" aria-controls="collapse_{{$pedido->id}}">
                                                Ver detalle del pedido
                                            </button>
                                        </div>
                                    </div>

                                </h3>
                            </div>

                            <div id="pedido_{{$pedido->id}}" class="collapse " aria-labelledby="heading_{{$pedido->id}}"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            @if (is_null($pedido->pago_id))

                                            <button type="submit" name="delete" data-id="{{$pedido->id}}"
                                                class="deletePedido btn btn-danger btn-sm">Eliminar Pedido</button>
                                            @endif

                                        </div>
                                        <div class="col-1">
                                            <a class="nav-link" data-toggle="dropdown" href="#">
                                                <i class="fas fa-question-circle" style="font-size: 200%"></i>
                                            </a>



                                        </div>

                                    </div>

                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            @if (!is_null($pedido->seguimientoEnvio))

                                            <tr class="text-center ">
                                                <td colspan="7" class="border border-success"><a
                                                        href="{{$pedido->seguimientoEnvio}}">Ir al seguimiento de
                                                        envio</a></td>
                                            </tr>


                                            @endif
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Precio Unitario</th>
                                                <th scope="col">Detalle</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Estado</th>
                                                {{-- <th scope="col">Verificado</th> --}}
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedido->detallePedidos as $detalle)
                                            @if ($detalle!=null)


                                            <tr>
                                                <th scope="row">{{$detalle->id}}</th>
                                                <td>{{$detalle->producto->modelo->nombre}}</td>
                                                <td align="right">
                                                    ${{' '.number_format($detalle->producto->modelo->precioUnitario,2)}}
                                                </td>
                                                <td>{{$detalle->detalle}}</td>
                                                <td align="right">{{number_format($detalle->cantidad)}}</td>
                                                @if ($detalle->estado !=null)
                                                {{-- <td>{{$detalle->estado->nombre}}</td>

                                                @else --}}
                                                <td>
                                                    @if ($detalle->getEstadoFinal()->id == $detalle->estado->id)
                                                    <span
                                                        class="badge badge-danger">{{$detalle->estado->nombre ?? 'Sin Estado'}}
                                                    </span>

                                                    @else
                                                    <span
                                                        class="badge badge-warning">{{$detalle->estado->nombre ?? 'Sin Estado'}}
                                                    </span>

                                                    @endif
                                                </td>

                                                @endif
                                                {{-- <td>
                                                        @if (!is_null($pedido->pago_id))
                                                        @if (is_null($detalle->verificado))
                                                        <div class=" text-center "
                                                            title="El producto esta en espera para ser revisado por la empresa">
                                                            <i class="icon fas fa-exclamation-triangle alert-warning  p-0 m-0"
                                                                style="font-size: 200%; border-radius: 10%"></i>
                                                            <p class="alert-warning p-0 m-0 " style="border-radius: 10%">En
                                                                Verificacion!</p>
                                                        </div>



                                                        @else
                                                        @if ($detalle->verificado)
                                                        <div class=" text-center "
                                                            title="El producto fue aprobado para la produccion">
                                                            <i class="icon fas fa-check alert-success  p-0 m-0"
                                                                style="font-size: 200%; border-radius: 10%"></i>
                                                            <p class="alert-success p-0 m-0 " style="border-radius: 10%">
                                                                Aprobado!</p>
                                                        </div>

                                                        @else
                                                        <div class=" text-center "
                                                            title="El producto fue rechazado debe revisar las imagenes y materias primas">
                                                            <i class="icon fas fa-ban alert-danger  p-0 m-0"
                                                                style="font-size: 200%; border-radius: 100%"></i>
                                                            <p class="alert-danger p-0 m-0 " style="border-radius: 10%">
                                                                {{$detalle->aviso}}</p>
                                </div>





                                @endif

                                @endif
                                @else
                                Falta Pagar
                                @endif
                                </td> --}}
                                <td>
                                    <div class="row">

                                        @if (!is_null($detalle->pedido))


                                            @if ($detalle->pedido->pago_id)
                                                <a href="{{route('producto.preshow',$detalle->producto->id)}}" type="button"
                                                    name="show" id="{{$detalle->producto->id}}"
                                                    class="show btn btn-outline-primary btn-sm">Ver
                                                    Producto</a>
                                            @else
                                                @if ($detalle->producto->user->id==auth()->user()->id)
                                                    @if ($detalle->producto->final)
                                                        <a href="{{route('producto.preshow',$detalle->producto->id)}}" type="button"
                                                            name="show" id="{{$detalle->producto->id}}"
                                                            class="show btn btn-outline-primary btn-sm">Ver
                                                            Producto</a>
                                                    @else
                                                        <a href="{{route('producto.editMiProducto',$detalle->producto->id)}}"
                                                            type="button" name="show" id="{{$detalle->producto->id}}"
                                                            class="show btn btn-outline-primary btn-sm">Editar
                                                            Producto</a>
                                                    @endif





                                                @else
                                                    <a href="{{route('producto.preshow',$detalle->producto->id)}}" type="button"
                                                        name="show" id="{{$detalle->producto->id}}"
                                                        class="show btn btn-outline-primary btn-sm">Ver
                                                        Producto</a>

                                                @endif
                                                    @if (is_null($pedido->pago_id))
                                                    <div class="col">
                                                        <button type="button" name="edit" data-id="{{$detalle->id}}"
                                                            class="edit btn btn-outline-info btn-sm">Editar
                                                            detalle</button>

                                                    </div>
                                                    <div class="col">


                                                        <button type="submit" name="delete" id="{{$detalle->id}}"
                                                            class="deleteDetalle btn btn-outline-danger btn-sm">Eliminar</button>

                                                    </div>
                                                @endif


                                            @endif
                                        @endif








                                    </div>
                                </td>
                                </tr>
                                @endif
                                @endforeach
                                @if (is_null($pedido->pago_id))
                                @if (is_null($pedido->preference_id))

                                <tr>
                                    <th colspan="7" style="font-size: 18px">
                                        <div class="row">
                                            <div class="col">

                                                <a href="{{ route('producto.tienda') }}" class="">
                                                    <button type="button" class="btn btn-outline-success btn-sm">Añadir
                                                        Nuevo Producto</button>


                                                </a>
                                            </div>

                                        </div>
                                    </th>
                                </tr>
                                @endif
                                @endif


                                <tr>
                                    <th colspan="6" style="font-size: 18px">Total :
                                        ${{number_format($pedido->getPrecio(),2)}}
                                    </th>
                                    <th>
                                        @if (is_null($pedido->pago_id))

                                        @if ($pedido->estado->id
                                        ==$pedido->flujoTrabajo->getEstadoInicial()->id )
                                        <form action="{{ route('pedido.confirmarPedido', $pedido->id) }}">

                                            <button type="submit" name="confirmarPedido"
                                                class=" btn btn-success btn-md">Pagar
                                                Pedido</button>
                                        </form>


                                        @endif


                                        @endif


                                    </th>
                                </tr>

                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    @endforeach
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
@include('detallePedido.edit')
@endsection

@push('scripts')
<script>
    $('#create_record').click(function(){
        $('.modal-title').text("Modelos para el producto");
        
        $('#formModal').modal('show');
    });
    
    $(document).on('click', '.edit', function(){
        var id = $(this).attr('data-id');
        
        $("#editDetallePedido_form").attr("action","/detallePedido/update/"+id);
        
        
        
        var url="{{route('detallePedido.edit',":id")}}";
        url=url.replace(':id',id);
        console.log(url);
        $.get(url,function(array){
            console.log(array);
            
            $('#cantidad').val(array['data'].cantidad);
            $('#detalle').val(array['data'].detalle);
            
            
        });
       
        $('.modal-title').text("Editar Detalle Del Pedido");
        $('#editDetallePedido').modal('show');
        
        
    }); 
    
        $(document).on('click', '.deleteDetalle', function(){
            var id = $(this).attr('id');
            $('#button_delete').val(id);
            $('#ok_button').text('Ok')
            $('.modal-title').text("Confirmacion");
            url2="{{route('detallePedido.destroy',":id")}}";
                                            
             url2=url2.replace(':id',id);
            $('#formDelete').attr('action',url2);
            $('#confirmModal').modal('show');
        });
        $(document).on('click', '.deletePedido', function(){
            var id = $(this).attr('data-id');
            $('#button_delete').val(id);
            $('#ok_button').text('Ok')
            $('.modal-title').text("Confirmacion");
            url2="{{route('pedido.destroy',":id")}}";
                                            
             url2=url2.replace(':id',id);
            $('#formDelete').attr('action',url2);
            $('#confirmModal').modal('show');
        });
        
        $('#formDelete').on('submit',function(){
            $('#ok_button').text('Eliminando...')
        });


</script>
@endpush