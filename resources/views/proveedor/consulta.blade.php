<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consulta de Materia Primas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('admin_panel/plugins/select2/css/select2.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin_panel/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin_panel/dist/css/adminlte.min.css') }}">
</head>
<header>
    @include('admin_panel/header')
    @include('layouts.mensaje')

    <br>
    <div class="row" style="height: 100px">
        <div class="col-2"></div>
        <div class="col">
            <div class="img">

                {{-- <img class="imagen" src="{{asset("images/logo2.jpeg")}}" alt="" style="width: 20rem"> --}}
                <img class="imagen" src="{{asset("imagenes/configuraciones/").'/'.$configuracion->imagenPrincipal}}" alt="" style="width: 20rem">

            </div>

        </div>
        <div class="col">

            <div class="justify-content-center">
                <div class="text-center">
                    <h5><strong>{{$configuracion->nombre}}</strong></h5>
                    @if ($configuracion->direccion != null)

                    <strong style="font-size: 12px">{{$configuracion->direccion->obtenerDireccion()}}</strong>
                    @endif
                    <h6><strong>Telefono:{{$configuracion->telefono}}</strong></h6>


                </div>
            </div>
        </div>
        <div class="col">

            <div class="float-right" style="font-size: 12px">
                <h6><strong>Fecha:</strong> {{ Carbon\Carbon::now()->format('d/m/Y') }}</h6>
                <h6><strong>Hora:</strong> {{ Carbon\Carbon::now()->format('H:i' ) }}</h6>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</header>

<body>
    <form action="{{ route('proveedor.obtenerPrecios', $proveedor->id) }}">
        <div class="container align-items-center">
            <br>
            <br>
            <div class="text-center">
                @if ($proveedor->propuestaPendiente()!=null)
                <h3>Bienvendio {{$proveedor->nombre}} le agradeceriamos que respondiera los siguientes campos</h3>
                @else
                <div class="text-center">
                    <a type="button" href="{{ route('home') }}" class="btn btn-success">Ir Al Inicio</a>
                </div>

                @endif
            </div>
            <br>
            <input type="hidden" value="{{$cantidadMaterias=0}}">
            @foreach ($proveedor->materiaPrimas as $materia)
            @if ($materia->cantidad <= $materia->stockMinimo)
                @if (!$proveedor->obtenerPropuesta($materia->id)->realizado)

                <div class="form-group">

                    <div class="card">


                        <div class="card-body ">

                            <div class="row">



                                <div class="form-group">

                                    <div class="col">
                                        <img src="{{ asset('/imagenes/materia_primas/'.$materia->imagenPrincipal) }}"
                                            class="card-img-top" alt="..." style="width: 15rem">
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="col">

                                        <div class="card">
                                            <div class="card-header">

                                                <h3 class="text-center">Informacion</h3>
                                            </div>

                                            <div class="card-body ">



                                                <div class="row">
                                                    <p>Nombre: {{$materia->nombre}}</p>
                                                </div>
                                                <div class="row">
                                                    <p>Detalle: {{$materia->detale ?? 'No hay detalles'}}</p>
                                                </div>
                                                <div class="row">
                                                    <p>Unidad De Medida: {{$materia->medida->nombre}}</p>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">

                                        <div class="card-header">

                                            <h3 class="text-center">Complete los siguientes campos</h3>
                                        </div>
                                        <div class="card-body ">




                                            <div class="row">


                                                <label class="control-label ">Unidad De Medida Que Usted Utiliza:
                                                </label>
                                                <select class="form-control select2 "
                                                    id="medida_id_materia_{{$materia->id}}"
                                                    name="medida_id_materia_{{$materia->id}}">

                                                    @foreach ($medidas as $medida)
                                                    <option value="{{$medida->id}}"> {{$medida->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="form-group ">
                                                    <label class="control-label">Precio Unitario : </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="text" class="form-control text-left"
                                                            id="precioUnitario_materia_{{$materia->id}}"
                                                            name="precioUnitario_materia_{{$materia->id}}" data-mask
                                                            data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false,  'placeholder': '0'">

                                                    </div>


                                                </div>

                                            </div>
                                            <div class="row">

                                                <p>¿Alguna informacion extra?: <textarea
                                                        name="informacion_materia_{{$materia->id}}" id=""
                                                        class="form-control" cols="50" rows="5"
                                                        style="resize: none"></textarea></p>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <input type="hidden" name="materia_{{$cantidadMaterias++}}" value="{{$materia->id}}">
                @endif

                @endif

                @endforeach
                <input type="hidden" name="cantidadMaterias" value="{{$cantidadMaterias}}">
                @if ($proveedor->propuestaPendiente()!=null)
                <div class="text-right">
                    <button type="submit" class="btn btn-success">Enviar Datos</button>
                </div>

                @endif
        </div>


    </form>

</body>
<script src="{{ asset('js/app.js') }}"></script>
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}

<!-- jQuery -->
<script src="{{asset('admin_panel/plugins/jquery/jquery.min.js')}}"></script>

<script src="{{asset('admin_panel/plugins/inputmask/jquery.inputmask.bundle.js')}}"></script>


<!-- Bootstrap 4-->
<script src="{{asset('admin_panel/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('admin_panel/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE App -->
{{-- <script src="{{asset('admin_panel/dist/js/adminlte.min.js')}}"></script> --}}
<!-- DataTables -->
<script src="{{asset('admin_panel/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin_panel/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('admin_panel/plugins/select2/js/select2.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('admin_panel/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('admin_panel/plugins/moment/moment-with-locales.min.js')}}"></script>

<script src="{{asset('admin_panel/dist/js/demo.js')}}"></script>
{{-- java script interact --}}
<script src="{{asset('js/interactjs.js')}}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script> --}}

<!-- Ion Slider -->
<script src="{{asset('admin_panel/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>

</html>
<script>
    $('.select2').select2();
    $('[data-mask]').inputmask();
    $('.dropdown-toggle').dropdown();
</script>