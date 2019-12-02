@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ route('usuario.modificar') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card text-left">


                    <div class="card-header">
                        <h3>Datos de Perfil</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>

                        </div>
                        <span id="form_result"></span>
                        <div class="row">

                            <label for="">Subir Imagen</label>
                        </div>
                        <hr>
                        <div class=" justify-content-center row">
                            <input type="file" name="imagenPrincipal" id="imagenPrincipal">

                        </div>
                        <div class=" justify-content-center row">

                            <div id="preview" class="row justify-content-center">
                                <img src="{{ asset('/imagenes/usuarios/'.$usuario->imagenPrincipal) }}" alt=""
                                    height="200px" width="200px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="control-label">Nombre: </label>
                                <input type="text" name="nombre" id="nombre" required placeholder="Ingrese un Nombre"
                                    class="form-control" value="{{$usuario->name ?? ''}}" />
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="control-label">Apellido: </label>
                                <input type="text" name="apellido" id="apellido" required
                                    placeholder="Ingrese un Apellido" class="form-control"
                                    value="{{$usuario->apellido ?? ''}}" />
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="email" class="control-label">Email: </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{$usuario->email ?? ''}}" required autocomplete="email"
                                    placeholder="Ingrese Email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                        </div>



                        <hr>

                        {{-- Documento************************************************************* --}}
                        <div class="form-group row">
                            <div class="col">
                                <label class="control-label">Seleccione el Tipo de Documento: </label>
                                <div class="input-group mb-3">
                                    <select class="select2" id='documento_id' name="documento_id"
                                        data-placeholder="Seleccione Un Documento" style="width: 100%;">

                                        @if (!is_null($usuario->documento))
                                        @if(sizeof($documentos)>0)
                                        @foreach ($documentos as $documento)
                                        @if ($usuario->documento->id == $documento->id)

                                        <option value="{{$documento->id}}" selected>{{$documento->nombre}}</option>

                                        @else
                                        <option value="{{$documento->id}}">{{$documento->nombre}}</option>

                                        @endif
                                        @endforeach
                                        @endif
                                        @else
                                        @foreach ($documentos as $documento)

                                        <option value="{{$documento->id}}">{{$documento->nombre}}</option>

                                        @endforeach
                                        @endif


                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label class="control-label">Numero de documento: </label>
                                <input type="text" name="numeroDocumento" id="numeroDocumento" required
                                    placeholder="Ingrese el numero de documento" class="form-control"
                                    value="{{$usuario->numeroDocumento ?? ''}}" />

                            </div>

                        </div>



                        {{-- Direcciones creadas******************************************************************** --}}

                        {{-- Direcciones******************************************************************** --}}
                        <br>



                    </div>
                    <div class="card-footer text-muted text-right">
                        {{-- 2 days ago --}}
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>
                </div>
            </form>


            <div class="card">

                <div class="card-header">
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                    <h3>Direccion (*)</h3>
                    <p class="text-muted"> La direccion la usamos para enviarte el producto</p>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col">

                            <label class="control-label">Direccion Predeterminada: </label>

                            <form action="#predeterminadoSelect" id="form-predeterminado" method="get">
                                @csrf

                                <div class="input-group mb-3 ">
                                    <select class="select2" id='predeterminadoSelect' name="predeterminado_id"
                                        data-placeholder="Seleccione Una Direccion" style="width: 100%;">
                                        @if(!$usuario->direccionEnvios->isEmpty()))
                                        @foreach ($usuario->direccionEnvios as $direccionEnv)
                                        @if ($direccionEnv->predeterminado)
                                        <option value="{{$direccionEnv->id}}" selected>
                                            {{$direccionEnv->direccion->obtenerDireccion()}}</option>

                                        @else
                                        <option value="{{$direccionEnv->id}}">
                                            {{$direccionEnv->direccion->obtenerDireccion()}}</option>

                                        @endif
                                        @endforeach
                                        @else
                                        <option value="">No Tiene Direcciones</option>
                                        @endif
                                    </select>



                                </div>
                                <button type="submit" class="btn  btn-primary"> Predeterminada</button>

                            </form>


                        </div>

                    </div>




                    <form id="direccion-form" action="{{ route('usuario.crearDireccion') }}" method="post">
                        @csrf


                        <div class="form-group row ">
                            <div class="col">
                                <label class="control-label">Numero de Domicilio: </label>
                                <input type="text" class="form-control text-left" name="domicilio" id="domicilio"
                                    data-mask data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': true">

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col">

                                <label class="control-label">Calle: </label>



                                <div class="input-group mb-3 ">

                                    {{-- <select class="select2" id='calle_id' name="calle_id"
                                            data-placeholder="Seleccione Una Calle" style="width: 100%;"
                                            aria-describedby="boton-agregar-calle" required>
                                            @if(sizeof($calles)>0)
                                            @foreach ($calles as $calle)
                                            <option value="{{$calle->id}}">{{$calle->nombre}}</option>
                                    @endforeach
                                    @endif
                                    </select> --}}
                                    <select class="select2" id='calle_id' name="calle_id"
                                        data-placeholder="Seleccione Una Calle" style="width: 100%;"
                                        aria-describedby="boton-agregar-calle" required>
                                        @if (!is_null($usuario->calle))
                                        @if(sizeof($calles)>0)
                                        @foreach ($calles as $calle)
                                        @if ($usuario->calle->id == $calle->id)

                                        <option value="{{$calle->id}}" selected>{{$calle->nombre}}</option>
                                        @else
                                        <option value="{{$calle->id}}">{{$calle->nombre}}</option>

                                        @endif
                                        @endforeach
                                        @endif
                                        @else
                                        @foreach ($calles as $calle)

                                        <option value="{{$calle->id}}">{{$calle->nombre}}</option>

                                        @endforeach
                                        @endif


                                    </select>


                                </div>



                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col">
                                <label class="control-label">Localidad: </label>
                                <div class="input-group mb-3 ">
                                    {{-- <select class="select2" id='localidad_id' name="localidad_id"
                                            data-placeholder="Seleccione Una Localidad" style="width: 100%;"
                                            aria-describedby="boton-agregar-localidad" required>
                                            @if(sizeof($localidades)>0)
                                            @foreach ($localidades as $localidad)
                                            <option value="{{$localidad->id}}">{{$localidad->nombre}}</option>
                                    @endforeach
                                    @endif
                                    </select> --}}
                                    <select class="select2" id='localidad_id' name="localidad_id"
                                        data-placeholder="Seleccione Una Localidad" style="width: 100%;"
                                        aria-describedby="boton-agregar-localidad" required>
                                        @if (!is_null($usuario->localidad))
                                        @if(sizeof($localidades)>0)
                                        @foreach ($localidades as $localidad)
                                        @if ($usuario->localidad->id == $localidad->id)

                                        <option value="{{$localidad->id}}" selected>{{$localidad->nombre}}
                                        </option>
                                        @else
                                        <option value="{{$localidad->id}}">{{$localidad->nombre}}</option>

                                        @endif
                                        @endforeach
                                        @endif
                                        @else
                                        @foreach ($localidades as $localidad)

                                        <option value="{{$localidad->id}}">{{$localidad->nombre}}</option>

                                        @endforeach
                                        @endif


                                    </select>
                                </div>


                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label class="control-label">Provincia: </label>
                                <div class="input-group mb-3 ">
                                    {{-- <select required class="select2" id='provincia_id' name="provincia_id"
                                            data-placeholder="Seleccione Una Provincia" style="width: 100%;">
                                            @if(sizeof($provincias)>0)
                                            @foreach ($provincias as $provincia)
                                            <option value="{{$provincia->id}}">{{$provincia->nombre}}</option>
                                    @endforeach
                                    @endif
                                    </select> --}}
                                    <select required class="select2" id='provincia_id' name="provincia_id"
                                        data-placeholder="Seleccione Una Provincia" style="width: 100%;">
                                        @if (!is_null($usuario->provincia))
                                        @if(sizeof($provincias)>0)
                                        @foreach ($provincias as $provincia)
                                        @if ($usuario->provincia->id == $provincia->id)

                                        <option value="{{$provincia->id}}" selected>{{$provincia->nombre}}
                                        </option>
                                        @else
                                        <option value="{{$provincia->id}}">{{$provincia->nombre}}</option>

                                        @endif
                                        @endforeach
                                        @endif
                                        @else
                                        @foreach ($provincias as $provincia)

                                        <option value="{{$provincia->id}}">{{$provincia->nombre}}</option>

                                        @endforeach
                                        @endif


                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label class="control-label">Pais: </label>
                                <div class="input-group mb-3 ">
                                    {{-- <select required class="select2" id='pais_id' name="pais_id"
                                            data-placeholder="Seleccione Un Pais" style="width: 100%;">
                                            @if(sizeof($paises)>0)
                                            @foreach ($paises as $pais)
                                            <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                    @endforeach
                                    @endif
                                    </select> --}}
                                    <select required class="select2" id='pais_id' name="pais_id"
                                        data-placeholder="Seleccione Un Pais" style="width: 100%;">
                                        @if (!is_null($usuario->pais))
                                        @if(sizeof($paises)>0)
                                        @foreach ($paises as $pais)
                                        @if ($usuario->pais->id == $pais->id)

                                        <option value="{{$pais->id}}" selected>{{$pais->nombre}}</option>
                                        @else
                                        <option value="{{$pais->id}}">{{$pais->nombre}}</option>

                                        @endif
                                        @endforeach
                                        @endif
                                        @else
                                        @foreach ($paises as $pais)

                                        <option value="{{$pais->id}}">{{$pais->nombre}}</option>

                                        @endforeach
                                        @endif


                                    </select>

                                </div>

                            </div>

                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Crear Direccion</button>

                </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header ">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                    <h3>Cambiar Contraseña</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('usuario.cambiarPassword') }}" id="form_pass">
                        @csrf

                        {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}



                        {{-- <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Contraseña Actual') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password" required>
                        </div>
                </div> --}}
                <div class="form-group row">
                    <label for="password-confirm"
                        class="col-md-4 col-form-label text-md-right">{{ __('Nueva Contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="passNuevo" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password-confirm"
                        class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="passConfirmacion"
                            required>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-primary" id="ok_reset">
                            {{ __('Resetear ') }}
                        </button>
                    </div>
                </div>
                </form>
            </div>
            <div class="card-footer"></div>
        </div>

    </div>
</div>
</div>

@endsection


@section('htmlFinal')
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmacion</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">¿Esta seguro que desea cambiar su contraseña?</h4>
            </div>
            <div class="modal-footer">

                {{-- Paso el id de la materia  aborrar en boton_delete--}}
                <button type="button" name="ok_button" id="ok_button" class="btn btn-primary"
                    onclick="confimar()">OK</button>

                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('#predeterminadoSelect').change(
        function(){
            
            var url='{{route("usuario.direccionEnvioPredeterminada",':id')}}';
            url=url.replace(':id',$(this).val());
            console.log(url);
            $('#form-predeterminado').attr('action',url);

        }
    );
    $(document).ready(function(){

        $('#ok_button').click(function () {
            // $('#form_pass').submit();
            document.getElementById('form_pass').submit();
          });
    
          $('#ok_reset').click(function () {
              $('#confirmModal').modal('show');
            });

            
        });
                document.getElementById("imagenPrincipal").onchange = function(e) {
                // Creamos el objeto de la clase FileReader
                
                let reader = new FileReader();
                
                // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                reader.readAsDataURL(e.target.files[0]);
                
                // Le decimos que cuando este listo ejecute el código interno
                reader.onload = function(){
                    let preview = document.getElementById('preview'),
                    image = document.createElement('img');
                    image.src = reader.result;
                    image.height='200';
                    image.width='200';
                    preview.innerHTML = '';
                    preview.append(image);
                };
            }
  
    

</script>
@endpush