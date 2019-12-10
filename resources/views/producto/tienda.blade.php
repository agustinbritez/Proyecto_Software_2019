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


                <div class="card-header">

                    <h3>Buscar Producto</h3>

                    <div align="right">
                        <button type="submit" id="create_record" class="btn btn-success btn-sm">Crear Mi
                            Producto</button>
                    </div>




                </div>
                <div class="card-body row">

                    <div class="form-group col">
                        <label>Nombre : </label>
                        <input class="form-control" type="text" name="nombre" id="nombre"
                            data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
                    </div>

                    <div class="form-group col">
                        <label>Modelo : </label>
                        <select class="form-control select2 " id="" name="modelos">
                            @foreach ($modelosVentas as $modelo)

                            <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
                            @endforeach

                        </select>

                    </div>
                    <div class="form-group col">
                        <label>Tipo Imagen : </label>
                        <select class="form-control select2 " id="" name="modelos">
                            @foreach ($tipoImagenes as $tipo)

                            <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group col">
                        <label>Imagen : </label>
                        <select class="form-control select2 " id="" name="modelos">
                            @foreach ($imagenes as $imagen)

                            <option value="{{$imagen->id}}">{{$imagen->nombre}}</option>
                            @endforeach

                        </select>
                    </div>


                </div>
                <div class="card-footer text-muted">
                    <div class="text-center">
                        <button type="button" name="filtrar" id="filtrar" class="btn btn-success btn-sm">Buscar</button>
                        <button type="button" name="reiniciar" id="reiniciar" class="btn btn-info btn-sm">Reiniciar
                            Busqueda</button>
                    </div>
                </div>
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

                            <h5 class="text-cyan">{{$producto->modelo->nombre}}</h5>
                            <h5 class="text-dark">{{'$ '.number_format($producto->modelo->precioUnitario,2)}}</h5>


                        </div>
                        <div class="text-center">
                            @guest
                            <a class="btn bg-gradient-teal btn-pill pt-1 pb-1 " href="{{ route('login') }}"
                                type="button" data-id="{{$producto->id}}">
                                Agregar
                            </a>
                            @else
                            @if (auth()->user()->hasRole('cliente')||auth()->user()->hasRole('admin'))

                            <button class="btn bg-gradient-teal btn-pill pt-1 pb-1 agregarCarrito" type="button"
                                data-id="{{$producto->id}}">
                                Agregar
                            </button>
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

@endsection

@section('htmlFinal')
@include('producto.modalTienda')
@endsection
@push('scripts')
<script>

</script>
@endpush