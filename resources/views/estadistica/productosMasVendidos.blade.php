@extends('admin_panel.index')


@section('content')


<div class="row">

    <div class="container">
        <div class="card  card-info  card-outline">


            <div class="card-header">

                <h3>Productos Mas Vendidos </h3>


            </div>
            <form action="{{ route('estadistica.filtroEvolucionProducto') }}">

                <div class="card-body ">
                    <div class="row">

                        <div class="form-group col">
                            <label>Filtrar Desde</label>
                            <input type="date" id="productosMasVendidosDesde" name="productosMasVendidosDesde" value=""
                                class="form-control">
                        </div>

                        <div class="form-group col">
                            <label>Filtrar Hasta</label>
                            <input type="date" id="productosMasVendidosHasta" name="productosMasVendidosHasta" value=""
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    <div class="text-center">

                        <button type="submit" name="filtrar" id="filtrar" class="btn btn-success btn-sm">Buscar</button>
                        {{-- <button type="button" name="reiniciar" id="reiniciar" class="btn btn-info btn-sm">Reiniciar
                            Busqueda</button> --}}
                    </div>
                </div>
            </form>
        </div>
        <div class="row">

            {!! $productosMasVendidos->container()!!}


        </div>
        <div class="card  card-info  card-outline">


            <div class="card-header">

                <h3>Evolucion del Producto</h3>
            </div>
            <form action="{{ route('estadistica.filtroEvolucionProducto') }}">


                <div class="card-body ">
                    <div class="row">

                        <div class="form-group col">
                            <label>Productos : </label>
                            <select class="form-control select2 " id="modelosEvolucionProducto" multiple
                                name="modelosEvolucionProducto[]">
                                @foreach ($modelos as $modelo)

                                <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
                                @endforeach

                            </select>

                        </div>

                        <div class="form-group col">
                            <label>Filtrar Desde</label>
                            <input type="date" id="evolucionProductoDesde" name="evolucionProductoDesde" value=""
                                class="form-control">
                        </div>

                        <div class="form-group col">
                            <label>Filtrar Hasta</label>
                            <input type="date" id="evolucionProductoHasta" name="evolucionProductoHasta" value=""
                                class="form-control">
                        </div>
                        <div class="form-group col">
                            <label>Dias de separacion</label>
                            <input type="text" class="form-control text-left" name="diasSeparacion" id="diasSeparacion"
                                placeholder="Dias" data-mask
                                {{-- data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false"> --}}
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0,
                            'digitsOptional': false, 'placeholder': '0'">
                        </div>
                    </div>


                </div>
                <div class="card-footer text-muted">
                    <div class="text-center">
                        <button type="submit" name="filtrar" id="filtrar" class="btn btn-success btn-sm">Buscar</button>
                        {{-- <button type="button" name="reiniciar" id="reiniciar" class="btn btn-info btn-sm">Reiniciar
                            Busqueda</button> --}}
                    </div>
                </div>

            </form>
        </div>

        <div class="row">

            {!! $evolucionProducto->container()!!}


        </div>
    </div>
</div>





@endsection



@section('htmlFinal')
{!! $evolucionProducto->script()!!}
{!! $productosMasVendidos->script()!!}
<script>
    $('#diasSeparacion').val('{{$vuelto->diasSeparacion ??""}}');
        $('#evolucionProductoHasta').val('{{$vuelto->evolucionProductoHasta ?? ""}}');
        $('#evolucionProductoDesde').val('{{$vuelto->evolucionProductoDesde ?? ""}}');
        $('#productosMasVendidosDesde').val('{{$vuelto->productosMasVendidosDesde ?? ""}}');
        $('#productosMasVendidosHasta').val('{{$vuelto->productosMasVendidosHasta ?? ""}}');

</script>
@if ($vuelto->has('modelosEvolucionProducto'))
@foreach ($vuelto->modelosEvolucionProducto as $item)
<script>
    console.log($('#modelosEvolucionProducto').val())
    $('#modelosEvolucionProducto').val($('#modelosEvolucionProducto').val().concat(['{{$item}}']));
</script>
@endforeach
@endif
@endsection