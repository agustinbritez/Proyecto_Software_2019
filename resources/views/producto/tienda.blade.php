@extends('admin_panel.index')

@section('style')
<style>
    .contenido {

        /* width: 100%; */

        /* height: 200px; */

        background-color: lightgoldenrodyellow;

        color: white;

        overflow: hidden;

        white-space: nowrap;

        text-overflow: ellipsis;

    }
</style>
@endsection
@section('content')








<br>

<div class="container">

    <div id="avisos">

    </div>



    <div class="row">
        <div class="col">

            <div class="card text-left card-info  card-outline">
                <form action="{{ route('producto.filtrarTienda') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">

                        <h3>Buscar Producto</h3>

                        <div align="right">
                            <button type="button" id="create_record" class="btn btn-success btn-sm">Crear Mi
                                Producto</button>
                        </div>




                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="form-group col">
                            <label>Nombre : </label>
                            <input class="form-control" type="text" name="nombre" id="nombre"
                                data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
                        </div> --}}
                            <div class="form-group col-3 ">
                                <label class="control-label " style="font-size:15px ">Precio Unitario Minimo - Maximo:
                                </label>
                                <div class="row">
                                    <div class="col">

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control text-left"
                                                id="filtro_precioUnitarioMin" name="filtro_precioUnitarioMin" data-mask
                                                data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false,  'placeholder': '0.00'">
                                        </div>
                                    </div>
                                    <div class="col">

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control text-left"
                                                id="filtro_precioUnitarioMax" name="filtro_precioUnitarioMax" data-mask
                                                data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false,  'placeholder': '0.00'">
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group col">
                                <label>Modelo : </label>
                                <select class="form-control select2 " id="modelos" name="modelos">
                                    <option value="-1">Cualquiera</option>
                                    @foreach ($modelosVentas as $modelo)

                                    <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
                                    @endforeach

                                </select>

                            </div>
                            <div class="form-group col">
                                <label>Tipo Imagen : </label>
                                <select class="form-control select2 " id="tipoImagen" name="tipoImagen">
                                    <option value="-1">Cualquiera</option>
                                    @foreach ($tipoImagenes as $tipo)

                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col">
                                <label>Imagen : </label>
                                <select class="form-control select2 " id="imagenSeleccionada" name="imagenSeleccionada">
                                    <option value="-1">Cualquiera</option>
                                    @foreach ($imagenes as $imagen)

                                    <option value="{{$imagen->id}}">{{$imagen->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col">
                                <label>Ordenar Por Precio : </label>
                                <select class="form-control select2 " id="precios" name="precios">
                                    <option value="-1" selected>Cualquiera</option>
                                    <option value="0">Menor Precio</option>
                                    <option value="1">Mayor Precio</option>

                                </select>
                            </div>




                        </div>

                    </div>
                    <div class="card-footer text-muted">
                        <div class="text-center">
                            <button type="submit" name="filtrar" id="filtrar"
                                class="btn btn-success btn-sm">Buscar</button>
                            <button type="button" name="reiniciarBusqueda" id="reiniciarBusqueda" class="btn btn-info btn-sm">Reiniciar
                                Busqueda</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>

    </div>

    <div class="row">
        @foreach ($productos as $producto)

        <div class="form-group">
            <div class="col">
                <div class="card " style="width: 18rem;">
                    <img src="{{ asset('/imagenes/productos/'.$producto->imagenPrincipal) }}" class="card-img-top"
                        alt="..." height="250px">
                    <div class="card-body">
                        <div class="text-center">

                            <h5 class="text-cyan" style=" overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"
                                title="  {{$producto->modelo->nombre}}">
                                {{$producto->modelo->nombre}}</h5>
                            <h5 class="text-dark">{{'$ '.number_format($producto->modelo->precioUnitario,2)}}</h5>


                        </div>
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('producto.preshow',$producto->id) }}" method="GET">
                                    @csrf
                                    <button class="btn  btn-pill btn-outline-info pt-1 pb-1 verProducto" type="submit">
                                        Ver Producto
                                    </button>

                                </form>
                            </div>

                            @guest
                            <div class="col">

                                <a class="btn bg-gradient-teal btn-pill pt-1 pb-1 " href="{{ route('login') }}"
                                    type="button" data-id="{{$producto->id}}">
                                    Agregar<i class="far fa-shopping-cart nav-icon"></i>
                                </a>
                            </div>
                            @else
                            @if (auth()->user()->hasRole('cliente')||auth()->user()->hasRole('admin'))
                            <div class="col">
                                <button class="btn bg-gradient-teal btn-pill pt-1 pb-1 agregarCarrito" type="button"
                                    data-id="{{$producto->id}}">
                                    Agregar<i class="far fa-shopping-cart nav-icon"></i>
                                </button>

                            </div>
                            @endif

                            @endguest




                            {{-- <button type="button" class="btn btn-warning" id="agregarCarrito"
                                data-id="{{$producto->id}}">Agregar</button> --}}
                            {{-- botones --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endforeach
    </div>
</div>
<form action="{{ route('producto.tienda') }}" method="GET" id="reiniciarTodaLaVista">
    @csrf

</form>
@endsection

@section('htmlFinal')
@include('producto.modalTienda')
@endsection
@push('scripts')
<script>

</script>
@endpush