@extends('admin_panel.index')
@section('style')
<style>
  .resize-drag {
    background-color: #29e;
    color: white;
    font-size: 20px;
    font-family: sans-serif;
    border-radius: 0%;
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
                    src="{{asset('/imagenes/sublimaciones/'.$sublimacion->imagen->tipoImagen->nombre.'/'.$sublimacion->imagen->imagen )??'' }}"
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

              @if ($sublimacion->forma !=null)
              <img src="{{asset('/imagenes/sublimaciones/sinProcesar/'.$sublimacion->nuevaImagen)??'' }}"
                class="resize-drag" id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                height="{{(float)($sublimacion->alto)}}" width="{{(float)($sublimacion->ancho)}}"
                style="border-radius: {{$sublimacion->forma}}%;">
              @else
              <img src="{{asset('/imagenes/sublimaciones/sinProcesar/'.$sublimacion->nuevaImagen)??'' }}"
                class="resize-drag" id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                height="{{(float)($sublimacion->alto)}}" width="{{(float)($sublimacion->ancho)}}"
                style="border-radius: {{$sublimacion->forma}}%;">
              @endif


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
              <img
                src="{{asset('/imagenes/sublimaciones/'.$sublimacion->imagen->tipoImagen->nombre.'/'.$sublimacion->imagen->imagen )??'' }}"
                class="resize-drag" id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                height="{{(float)($sublimacion->alto)}}" width="{{(float)($sublimacion->ancho)}}"
                style="border-radius: {{$sublimacion->forma}}%;">

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
      interact('.resize-drag')
      .draggable({
        onmove: window.dragMoveListener,
        modifiers: [
        interact.modifiers.restrictRect({
          restriction: 'parent'
        })
        ]
      });
      // .resizable({
      //   // resize from all edges and corners
      //   edges: { left: true, right: true, bottom: true, top: true },
        
      //   modifiers: [
      //   // keep the edges inside the parent
      //   interact.modifiers.restrictEdges({
      //     outer: 'parent',
      //     endOnly: false
      //   }),
        
      //   // minimum size
      //   interact.modifiers.restrictSize({
      //     min: { width: 100, height: 50 }
      //   })
      //   ],
        
      //   inertia: true
      // })
      // .on('resizemove', function (event) {
      //   // var idNumeroDeImagen= event.target.getAttribute('data-id');
      //   // var idNumeroDeComponente= event.target.getAttribute('data-componente');
      //   // var comprobacion= event.target.getAttribute('data-imagen-sistema');
      //   // console.log('comprobacion: '+comprobacion);
      //   // console.log(event.target.getAttribute('data-id'));
        
      //   var target = event.target
      //   var x = (parseFloat(target.getAttribute('data-x')) || 0)
      //   var y = (parseFloat(target.getAttribute('data-y')) || 0)
        
      //   // update the element's style
      //   target.style.width = event.rect.width + 'px'
      //   target.style.height = event.rect.height + 'px'
      //   // ancho=event.rect.width;
      //   // alto=event.rect.height;
      //   // //guardamos el ancho y el lato de la imagen
      //   // if(comprobacion ==1){
      //   //   document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_ancho').setAttribute('value',ancho);
      //   //   document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_alto').setAttribute('value',alto);
          
      //   // }else{
          
      //   //   // document.getElementById('imagen_'+idNumeroDeImagen+'_alto').setAttribute('value',alto);
      //   //   document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_ancho').setAttribute('value',ancho);
      //   //   document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_alto').setAttribute('value',alto);
      //   // }
        
      //   // translate when resizing from top or left edges
      //   x += event.deltaRect.left
      //   y += event.deltaRect.top
        
      //   target.style.webkitTransform = target.style.transform ='translate(' + x + 'px,' + y + 'px)'
        
      //   target.setAttribute('data-x', x)
      //   target.setAttribute('data-y', y)
      //   //mostrar conteneido en el bloque
      //   //   target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height)
      //   target.textContent = ''
      //   // posx=x
      //   // posy=y
      //   // if(comprobacion ==1){
          
      //   //   document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posY').setAttribute('value',posy);
      //   //   document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posX').setAttribute('value',posx);
      //   // }else{
      //   //   document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posY').setAttribute('value',posy);
      //   //   document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posX').setAttribute('value',posx);
          
      //   // }
        
      // });
      
      function dragMoveListener(event) {
        // var idNumeroDeImagen= event.target.getAttribute('data-id');
        // var idNumeroDeComponente= event.target.getAttribute('data-componente');
        // var comprobacion= event.target.getAttribute('data-imagen-sistema');
        
        var target = event.target;
        console.log($('#'+target.id+'_posX').val());
          if(($('#'+target.id+'_posX').val()!=null)&&($('#'+target.id+'_posX').val()!='')){
              x=parseFloat($('#'+target.id+'_posX').val());
            }else{
              x=0;
            }
            
            if(($('#'+target.id+'_posY').val()!=null)&&($('#'+target.id+'_posY').val()!='')){
              y=parseFloat($('#'+target.id+'_posY').val());
            }else{
              y=0;
            }
        // keep the dragged position in the data-x/data-y attributes
        // var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
        // var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy
        // translate the element
        target.style.webkitTransform =
        target.style.transform =
        'translate(' + x + 'px, ' + y + 'px)'
        
        // update the posiion attributes
        target.setAttribute('data-x', x)
        target.setAttribute('data-y', y)

        // posx=x
        // posy=y
        //guardamos en los hidden la posicion x y de la imagen
        // document.getElementById('imagen_'+idNumeroDeImagen+'_posX').setAttribute('value',posx);
        // document.getElementById('imagen_'+idNumeroDeImagen+'_posY').setAttribute('value',posy);
        // if(comprobacion ==1){
          
        //   document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posY').setAttribute('value',posy);
        //   document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posX').setAttribute('value',posx);
        // }else{
        //   document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posY').setAttribute('value',posy);
        //   document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posX').setAttribute('value',posx);
          
        // }
      }
      
      // this is used later in the resizing and gesture demos
      window.dragMoveListener = dragMoveListener;
      
      
      
      
      
      
      for (let indiceComponente = 0; indiceComponente < cantidadComponente; indiceComponente++) {
        cantidadImagenes=document.getElementById('cantidadImagen_componente_'+indiceComponente).value;
        
        for (let index = 0; index < cantidadImagenes; index++) {
          imagen=document.getElementById('imagen_'+index+'_componente_'+indiceComponente);
          if(imagen!=null)
          {
            
            
            if(($('#imagen_'+index+'_componente_'+indiceComponente+'_ancho').val()!=null)&&($('#imagen_'+index+'_componente_'+indiceComponente+'_ancho').val()!='')){
              
              // posy=parseFloat($('#imagen_'+index+'_componente_'+indiceComponente+'_posY').val());
              ancho=imagen.style.width=parseFloat($('#imagen_'+index+'_componente_'+indiceComponente+'_ancho').val());
              
            }else{
              ancho=  imagen.style.width=120+'px';
            }
            
            if(($('#imagen_'+index+'_componente_'+indiceComponente+'_posX').val()!=null)&&($('#imagen_'+index+'_componente_'+indiceComponente+'_posX').val()!='')){
              posx=parseFloat($('#imagen_'+index+'_componente_'+indiceComponente+'_posX').val());
            }else{
              posx=0;
            }
            
            if(($('#imagen_'+index+'_componente_'+indiceComponente+'_posY').val()!=null)&&($('#imagen_'+index+'_componente_'+indiceComponente+'_posY').val()!='')){
              posy=parseFloat($('#imagen_'+index+'_componente_'+indiceComponente+'_posY').val());
            }else{
              posy=0;
            }
            if(($('#imagen_'+index+'_componente_'+indiceComponente+'_alto').val()!=null)&&($('#imagen_'+index+'_componente_'+indiceComponente+'_alto').val()!='')){
              alto= imagen.style.height=parseFloat($('#imagen_'+index+'_componente_'+indiceComponente+'_alto').val());
            }else{
              alto= imagen.style.height=50+'px';
            }
            
            console.log('x: '+posx+' y: '+posy+' alto:'+alto +' ancho: '+ancho);
            
             imagen.style.transform = 'translate(' + posx + 'px, ' + posy + 'px)';
          }
          // document.getElementById('imagen_'+index+'_componente_'+indiceComponente).setAttribute('value', document.getElementById(''));
          // document.getElementById('imagen_'+index+'_componente_'+indiceComponente+'_alto').setAttribute('value',alto);
          
          
        }
        
      } 
      
      
      
      
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