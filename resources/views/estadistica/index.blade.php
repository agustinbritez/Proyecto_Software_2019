@extends('admin_panel.index')


@section('content')

<div class="container">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Estadisticas</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="row">
                <div class="col-3">

                    {{-- <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Productos Mas Vendidos</h3>
                        </div>
                        <div class="card-body">
                            <div class="align-content-center">

                                <form action="{{ route('estadistica.productosMasVendidos') }}" method="GET">
                    <button type="submit" class="btn btn-success">Ver Grafico</button>
                    </form>

                </div>

            </div>
        </div> --}}
    </div>
</div>
<div class="row">

    <div class="col">

        <div class="card card-success">
            <div class="card-header ">
                <div class="row justify-content-center">

                    <h3 class="card-title">Productos Mas Vendidos Mensual</h3>
                </div>
            </div>
            <div class="card-body">
                <div width="50%">
                    {!! $productosMasVendidos->container()!!}
                </div>

            </div>
            <div class="card-footer">
                <div class="row justify-content-center">

                    <form action="{{ route('estadistica.evolucionProducto') }}" method="GET">
                        <button type="submit" class="btn btn-success">Filtrar Grafico</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col">

        <div class="card card-success">
            <div class="card-header ">
                <div class="row justify-content-center">
                    <h3 class="card-title">Ingresos Por Productos Mensual</h3>
                </div>
            </div>
            <div class="card-body">
                <div width="50%">
                    {{-- {!! $materiaPrimasMasConsumidas->container()!!} --}}
                    {!! $ingresoPorProducto->container()!!}
                </div>

            </div>
            <div class="card-footer">
                <div class="row justify-content-center">

                    <form action="{{ route('estadistica.ingresosProductos') }}" method="GET">
                        <button type="submit" class="btn btn-success">Filtrar Grafico</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<!-- /.card-body -->
<div class="card-footer">

</div>
<!-- /.card-footer -->
</div>
</div>


@endsection



@section('htmlFinal')
{!! $productosMasVendidos->script()!!}
{{-- {!! $materiaPrimasMasConsumidas->script()!!} --}}
{!! $ingresoPorProducto->script()!!}

@endsection