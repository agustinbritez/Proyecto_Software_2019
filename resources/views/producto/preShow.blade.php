@extends('admin_panel.index')
@section('style')
<style>
  .resize-drag {
    background-color: #29e;
    color: white;
    font-size: 20px;
    font-family: sans-serif;
    border-radius: 10%;
    /* padding: 20px; */
    margin: 30px 20px;
    touch-action: none;
    user-select: none;
    /* width: 120px; */

    /* This makes things *much* easier */
    box-sizing: border-box;
  }

  .resize-container {
    display: inline-block;
    width: 526px;
    height: 435px;
    background-repeat: no-repeat;
  }
</style>
@endsection

@section('content')



<br>
<input type="hidden" name="" id="" value="{{$cantidadComponente=0}}" />

@if ($producto!=null)
<div class=" ">


  <div class="row justify-content-around ">
    <div class="col-5">

      {{-- Otro cards --}}
      <div class="card text-left">

        <div class="card-header">

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

          </div>
          <h3 class="text-center">Materias Primas Seleccionadas</h3>
        </div>
        {{-- Se le pasa todos los modelos que tiene materia primas asociadas directamente en su recetas --}}
        <div class="card-body">
          <div class="row">




            <label class="control-label "> Ingredientes:</label> <br>
            @foreach ($producto->materiasPrimas as $materiaPrima)

            <input type="text" disabled class="form-control" value="{{$materiaPrima->nombre}}">

            @endforeach


          </div>


        </div>



        <div class="card-footer text-muted justify-content-center">
        </div>
      </div>
      {{-- Imagenes --}}
      <div class="card text-left">

        <div class="card-header">

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

          </div>

          <h3 class="text-center">Imagenes Seleccionada</h3>
        </div>


        <div class="card-body">


          <div class="row">


            @foreach ($producto->sublimaciones as $sublimacion)
            @if ($sublimacion!=null)

            <div class="form-group " id="add_imagen_componente_{{$sublimacion->id}}" style="margin-right:5%;">

              <input type="hidden" value="{{$cantidadImagenes=0}}">
              <div class="col ">
                <div id=" " style="max-width: 10rem;" class=" row justify-content-center">
                  @if ($sublimacion->nuevaImagen!=null)
                  <img src="{{asset("/imagenes/sublimaciones/sinProcesar/".$sublimacion->nuevaImagen)??'' }}" class=""
                    height="150" width="180">

                  @else
                  @if ($sublimacion->imagen !=null)
                  <img
                    src="{{asset("/imagenes/sublimaciones/".$sublimacion->imagen->tipoImagen."/".$sublimacion->imagen->imagen)??'' }}"
                    class="" height="150" width="180">

                  @endif
                  @endif
                </div>
                <div>
                  @if ($sublimacion->nuevaImagen!=null)


                  <button type="button" class="edit btn btn-default " data-id="{{$sublimacion->id}}"> Modificar
                    Imagen</button>
                  @endif
                </div>

              </div>


            </div>
            @endif
            @endforeach
          </div>



        </div>


        <div class="card-footer text-muted justify-content-center">
        </div>
      </div>

    </div>

    <div class="col-7">

      <div class="card text-left">

        <div class="card-header">

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

          </div>
          <h3 class="text-center">Componentes del producto</h3>
          <label class="control-label ">Seleccionar componente:</label>
          <select class="form-control select2 " id="componentes" name="componentes" onchange="cambiar();">
            <option value="" selected disabled>Seleccione el componente</option>
            @foreach ($producto->modelo->componentes as $componente)

            <option value="{{$componente->id}}" data-componente="{{$cantidadComponente++}}">
              {{$componente->nombre}}</option>
            @endforeach

          </select>
          {{-- <button type="button" class="btn btn-flat btn-info" onclick="cambiar();">Elegir</button> --}}
        </div>
        <input type="hidden" name="" id="" value="{{$cantidadComponente=0}}" />

        {{-- Se le pasa todos los modelos que tiene materia primas asociadas directamente en su recetas --}}
        <div class="card-body">


          @foreach ($producto->modelo->componentes as $componente)

          <div align="center" id="componente_{{$cantidadComponente}}" data-componente="{{$componente->id}}"
            style="display:none;">

            <div id="contenedor_{{$componente->id}}" class="resize-container"
              style="background-image: url('{{asset("/imagenes/componentes/".$componente->imagenPrincipal)??'' }}'); background-position:center; ">

              <input type="hidden" value="{{$cantidadImagenes=0}}">
              @foreach ($producto->sublimaciones as $sublimacion)

              @if ($sublimacion->componente->id==$componente->id)


              @if ($sublimacion->nuevaImagen!=null)


              <img src="{{asset('/imagenes/sublimaciones/sinProcesar/'.$sublimacion->nuevaImagen)??'' }}"
                class="resize-drag" id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                height="{{(float)($sublimacion->alto)}}" width="{{(float)($sublimacion->ancho)}}">

              <input type="hidden" name="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posX"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posX"
                value="{{$sublimacion->posX}}" />
              <input type="hidden" name="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posY"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posY"
                value="{{$sublimacion->posY}}" />
              <input type="hidden" name="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_alto"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_alto"
                value="{{$sublimacion->alto}}" />
              <input type="hidden" name="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_ancho"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_ancho"
                value="{{$sublimacion->ancho}}" />
              @else
              @if ($sublimacion->imagen!=null)

              <img src="{{asset($sublimacion->imagen->ruta )??'' }}" class="resize-drag"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                height="{{(float)($sublimacion->alto)}}" width="{{(float)($sublimacion->ancho)}}>
                <input type=" hidden" name="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posX"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posX"
                value="{{$sublimacion->posx}}" />
              <input type="hidden" name="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posY"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posY"
                value="{{$sublimacion->posy}}" />
              <input type="hidden" name="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_alto"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_alto"
                value="{{$sublimacion->alto}}" />
              <input type="hidden" name="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_ancho"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_ancho"
                value="{{$sublimacion->ancho}}" />

              @endif
              @endif

              @endif

              <input type="hidden" value="{{$cantidadImagenes++}}">
              @endforeach
            </div>

          </div>
          <input type="hidden" value="{{$cantidadImagenes}}" id="cantidadImagen_componente_{{$cantidadComponente++}}">


          @endforeach


        </div>



        <div class="card-footer text-muted justify-content-center">
        </div>
      </div>

    </div>


  </div>

</div>


@endif

@endsection

@section('htmlFinal')
<div id="formModal" class="modal fade" role="dialog">

  <div class="modal-dialog moddal-sm" role="document">
    <div class="modal-content ">

      <div class="modal-header">
        <div class="text-center">

          <h4 class="modal-title"> TITULO</h4>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">
          <div class="text-center">

            <p>Suba la imagen que remplazara al que el usuario subio</p>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group ">
                <label>Nombre : </label>
                <input class="form-control" type="text" name="nombre" id="nombre"
                  data-placeholder="Ingrese un nombre de la imagen">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label class="control-label ">Seleccionar Tipo Imagen : </label>
                <select class="form-control select2 " id="tipoImagen_id" name="tipoImagen_id">
                  @if (sizeof($tipoImagenes)>0)

                  @foreach ($tipoImagenes as $tipo)
                  <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                  @endforeach
                  @endif
                </select>

              </div>
            </div>
          </div>



          <div class="row justify-content-center">
            <div class="form-group" style="margin-right:5%;">
              <input type="hidden" name="sublimacion_id" value="">
              <label class="  ">
                Imagen Sin Procesar:

              </label>
              <div class=" " style="max-width: 10rem; ">
                <div id="preview_old" class=" row justify-content-center">
                  <img src="{{asset('/images/fondoBlanco.jpg')??'' }}" class="" height="150" width="180">

                </div>
                <div>
                  <label class="btn btn-default btn-file ">
                    Subir Imagen <i class="fas fa-upload ml-3" aria-hidden="true"></i>
                    <input type="file" id="" name="imagen_sinProcesar" style="display: none;"
                      onchange="cargar('preview_old');" class="cargarImagen">
                  </label>
                </div>

              </div>

            </div>

            <div class="form-group">
              <input type="hidden" name="sublimacion_id" value="">
              <label class="  ">
                Imagen Para Sistema:

              </label>
              <div class=" " style="max-width: 10rem; ">
                <div id="preview_new" class=" row justify-content-center">
                  <img src="{{asset('/images/fondoBlanco.jpg')??'' }}" class="" height="150" width="180">
                </div>

                <div>
                  <label class="btn btn-default btn-file ">
                    Subir Imagen <i class="fas fa-upload ml-3" aria-hidden="true"></i>
                    <input type="file" id="" name="imagen_new" style="display: none;" onchange="cargar('preview_new');"
                      class="cargarImagen">
                  </label>
                </div>

              </div>
            </div>
          </div>




        </div>
        <div class="modal-footer justify-content-around">

          <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Actualizar" />
          <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  var posx;
  var poxy;
  var alto;
  var ancho;
  var limiteImagen=6;
  var cantidadComponente= parseInt( "{{$cantidadComponente}}");
  var cantidadImagenes= 0;
  $(document).ready(function(){
    $('.cantidadImagenes_x').val(0);
    //*****************************cargar posiciones****************************************
    //  $('#componentes option:eq(0)').prop('selected', true);
    $('#componentes').prop('selectedIndex', 0);
    
    
    
  });
 
  //*********************************cambiar los componente**********************************8
  function cambiar(){
    
    var select = document.getElementById("componentes"); //El <select>
      
      value = select.value; //El valor seleccionado
      for (let index = 0; index < cantidadComponente; index++) {
        document.getElementById("componente_"+index).style.display='none';
        
      }
      numeroComponente=select.options[select.selectedIndex].getAttribute('data-componente') ;
      document.getElementById("componente_"+numeroComponente).style.display='block';
      
      // text = select.options[select.selectedIndex].innerText; //El texto de la opción seleccionada
      console.log(numeroComponente);
      
    }
    $('#prueba2').click(function(){
      
      $('#cantidadImagenes').val(cantidadImagenes);
      
      console.log('pos x: '+$('#posX').val() +'\n pos y: '+$('#posY').val());
    });
    
    $(document).on('click', '.edit', function(){
      var idSubli=$(this).attr('data-id'); 
      var url="{{route('sublimacion.update',":id")}}";
      url=url.replace(':id',idSubli);
      $('#sample_form').attr('action',url);
      $('.modal-title').text("Cambiar Imagen");
      $('#formModal').modal('show');


   });   
              
              
              //*********************************************************cargar imagen en las sublimaciones**********************************
              function cargar(id){
                // Creamos el objeto de la clase FileReader
                
                let reader = new FileReader();
                // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                reader.readAsDataURL(this.event.target.files[0]);
                
                // Le decimos que cuando este listo ejecute el código interno
                reader.onload = function(){
                  let preview = document.getElementById(id);
                  image = document.createElement('img');
                  image.src = reader.result;
                  image.class = 'img-fluid';
                  image.height='150';
                  image.width='180';
                  preview.innerHTML = '';
                  preview.append(image);
                 
                };
              };
              
              
              
              
              
              
</script>

@endpush