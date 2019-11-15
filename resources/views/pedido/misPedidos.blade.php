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


                <div class="card-body">
                    <form action="{{route('pdf.proveedor')}}" method="GET" enctype="multipart/form-data">
                        @csrf


                        <div class="row">

                            <div class="form-group col">
                                <label>Estado Actual : </label>
                                <select class="select2 form-control" name="filtro_estado" id="filtro_estado"
                                    data-placeholder="Seleccione Un Modelo">
                                    {{-- <option value="" selected>Cualquiera</option> --}}
                                    <option value="-1">Cualquiera</option>
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
                                <label>Estado Actual : </label>
                                <select class="select2 form-control" name="filtro_estado" id="filtro_estado"
                                    data-placeholder="Seleccione Un Modelo">
                                    {{-- <option value="" selected>Cualquiera</option> --}}
                                    <option value="-1">Cualquiera</option>
                                    @if(sizeof($estados)>0)
                                    @foreach ($estados as $estado)
                                    @if ($estado!=null)

                                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endif
                                    @endforeach

                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Numero de Documento : </label>
                                <input class="form-control" type="text" name="filtro_documento" id="filtro_documento"
                                    data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Email : </label>
                                <input class="form-control" type="text" name="filtro_email" id="filtro_email"
                                    data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
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


                    <div class="accordion" id="accordionExample">
                        @foreach ($misPedidos as $pedido)

                        <div class="card">
                            <div class="card-header" id="heading_{{$pedido->id}}">
                                <h3 class="mb-0" data-toggle="collapse" data-target="#pedido_{{$pedido->id}}"
                                    aria-expanded="true" aria-controls="pedido_{{$pedido->id}}">
                                    <div class="row">
                                        <div class="col">
                                            <span class="badge badge-light">{{'Numero de Pedido: '.$pedido->id}} </span>
                                            <span
                                                class="badge badge-warning">{{$pedido->estado->nombre ?? 'Sin Estado'}}
                                            </span>
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-primary" type="button" data-toggle="collapse"
                                                data-target="#collapse_{{$pedido->id}}" aria-expanded="true"
                                                aria-controls="collapse_{{$pedido->id}}">
                                                Ver detalle del pedido
                                            </button>
                                        </div>
                                    </div>

                                </h3>
                            </div>

                            <div id="pedido_{{$pedido->id}}" class="collapse " aria-labelledby="heading_{{$pedido->id}}"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Detalle</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Verificado</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedido->detallePedidos as $detalle)
                                            @if ($detalle!=null)


                                            <tr>
                                                <th scope="row">{{$detalle->id}}</th>
                                                <td>{{$detalle->producto->modelo->nombre}}</td>
                                                <td>{{$detalle->detalle}}</td>
                                                <td>{{$detalle->cantidad}}</td>
                                                @if ($detalle->estado !=null)
                                                <td>{{$detalle->estado->nombre}}</td>

                                                @else
                                                <td>Sin Estado</td>

                                                @endif
                                                @if ($detalle->verificado==0)

                                                <td>NO</td>
                                                @else
                                                <td>SI</td>
                                                @endif
                                                <td>
                                                    <div class="row">

                                                        <div class="col">
                                                            @if ($detalle->producto->user->id==auth()->user()->id)
                                                            {{-- Si el producto no se pago mostrar editar sino solo puede ver --}}
                                                            @if ($detalle->pedido->terminado==null)
                                                            <a href="{{route('producto.miProducto',$detalle->producto->id)}}"
                                                                type="button" name="show"
                                                                id="{{$detalle->producto->id}}"
                                                                class="show btn btn-outline-primary btn-sm">Editar
                                                                Producto</a>
                                                            @else
                                                            <a href="{{route('producto.preshow',$detalle->producto->id)}}"
                                                                type="button" name="show"
                                                                id="{{$detalle->producto->id}}"
                                                                class="show btn btn-outline-primary btn-sm">Ver
                                                                Producto</a>

                                                            @endif
                                                            {{-- Si el no creo el producto solo puede verlo --}}
                                                            @else
                                                            <a href="{{route('producto.preshow',$detalle->producto->id)}}"
                                                                type="button" name="show"
                                                                id="{{$detalle->producto->id}}"
                                                                class="show btn btn-outline-primary btn-sm">Ver
                                                                Producto</a>

                                                            @endif
                                                        </div>


                                                        <div class="col">
                                                            <button type="button" name="edit" data-id="{{$detalle->id}}"
                                                                class="edit btn btn-outline-info btn-sm">Editar
                                                                detalle</button>

                                                        </div>
                                                        <div class="col">

                                                            <form id="formDelete{{$detalle->id}}"
                                                                action="{{route('detallePedido.destroy',$detalle->id)}}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" name="delete"
                                                                    id="{{$detalle->producto->modelo->id}}"
                                                                    class="delete btn btn-outline-danger btn-sm">Eliminar</button>
                                                            </form>
                                                        </div>



                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach

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
    $(document).ready(function(){
        $('.select2').select2(
        // {theme: 'bootstrap4'}
        );
        $('[data-mask]').inputmask();
            
    });
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
            console.log('asd');
            
            $('#cantidad').val(array['data'].cantidad);
            $('#detalle').val(array['data'].detalle);
            
            
        });
       
        $('.modal-title').text("Editar Detalle Del Pedido");
        $('#editDetallePedido').modal('show');
        
        
    }); 
</script>
@endpush