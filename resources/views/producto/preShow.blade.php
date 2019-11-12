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

    </div>

    <div class="col-7">

      <div class="card text-left">

        <div class="card-header">

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

          </div>
          <h3 class="text-center">Personalice su producto</h3>
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


              <img src="{{asset('/imagenes/sublimaciones/'.$sublimacion->nuevaImagen)??'' }}" class="resize-drag"
                id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
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
    for (let indiceComponente = 0; indiceComponente < cantidadComponente; indiceComponente++) {
        cantidadImagenes=document.getElementById('cantidadImagen_componente_'+indiceComponente).value;
        
        for (let index = 0; index < cantidadImagenes; index++) {
          imagen=document.getElementById('imagen_'+index+'_componente_'+indiceComponente);
          if(imagen!=null)
          {
            
            if(($('#imagen_'+index+'_componente_'+indiceComponente+'_ancho').val()!=null)&&($('#imagen_'+index+'_componente_'+indiceComponente+'_ancho').val()!='')){

              posy=parseFloat($('#imagen_'+index+'_componente_'+indiceComponente+'_posY').val());
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

              imagen.style.webkitTransform = imagen.style.transform = 'translate(' + posx + 'px, ' + posy + 'px)';
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
      
      // *****************************************boton agreggar y quitar imagenes***********************************************************8
      $('.agregarImagen').click(function(){
        componenteSeleccionado=this.getAttribute('data-componente');
        cantidadImagenes=parseInt($('#cantidadImagenes_'+componenteSeleccionado).val());
        console.log('cantidad Imagnes: '+cantidadImagenes);
        if(cantidadImagenes<limiteImagen){
          
          cantidadImagenes++; 
          var nuevaImagen='<div class="form-group " id="add_imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'" style="margin-right:5%;">'
            +'<div class=" " style="max-width: 10rem; ">'
              +'<div id="preview_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'" class=" row justify-content-center">'
                +'<img src="{{asset("/images/fondoBlanco.jpg")??'' }}" class="" height="150" width="180">'
                +'</div>'
                +'<div>'
                  +'<label class="btn btn-default btn-file ">'
                    +'Subir Imagen <i class="fas fa-upload ml-3" aria-hidden="true"></i>'
                    +'<input type="file" id="'+cantidadImagenes+'" name="file_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'" style="display: none;" onchange="cargar('+cantidadImagenes+','+componenteSeleccionado+');"  class="cargarImagen">'
                    +'</label>'
                    +'</div>'
                    +'<input type="hidden" name="imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'_posX" id="imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'_posX" value="" />'
                    +'<input type="hidden" name="imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'_posY" id="imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'_posY" value="" />'
                    +'<input type="hidden" name="imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'_alto" id="imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'_alto" value="" />'
                    +'<input type="hidden" name="imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'_ancho" id="imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'_ancho" value="" />'
                    +'</div>'
                    +'</div>';
                    
                    $('#add_imagen_componente_'+componenteSeleccionado).append(nuevaImagen);
                    $('#contenedor_'+componenteSeleccionado).append('<img src="{{asset("/images/fondoBlanco.jpg")??'' }}" class="resize-drag" id="nuevaImagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'" data-id="'+cantidadImagenes+'" data-componente="'+componenteSeleccionado+'">');
                    
                    
                  }
                  $('#cantidadImagenes_'+componenteSeleccionado).val(cantidadImagenes);
                });
                $('.quitarImagen').click(function(){
                  componenteSeleccionado=this.getAttribute('data-componente');
                  
                  cantidadImagenes=parseInt($('#cantidadImagenes_'+componenteSeleccionado).val());
                  
                  $('#add_imagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado).remove();
                  
                  $('#nuevaImagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado).remove();
                  if(cantidadImagenes<=0){
                    cantidadImagenes=0;
                  }else{
                    
                    cantidadImagenes--;
                  }
                  $('#cantidadImagenes_'+componenteSeleccionado).val(cantidadImagenes);
                  
                });
                
                
             
               
                //*********************************************************cargar imagen en las sublimaciones**********************************
                function cargar(idImagen,componenteSeleccionado){
                  // Creamos el objeto de la clase FileReader
                  
                  let reader = new FileReader();
                  // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                  reader.readAsDataURL(this.event.target.files[0]);
                  
                  // Le decimos que cuando este listo ejecute el código interno
                  reader.onload = function(){
                    let preview = document.getElementById('preview_'+idImagen+'_componente_'+componenteSeleccionado);
                    image = document.createElement('img');
                    image.src = reader.result;
                    image.class = 'img-fluid';
                    image.height='150';
                    image.width='180';
                    preview.innerHTML = '';
                    preview.append(image);
                    // alert(image.src);
                    
                    document.getElementById('nuevaImagen_'+idImagen+'_componente_'+componenteSeleccionado).src=image.src;
                    
                    // $('.resize-drag').src(image.src);
                  };
                };
                
                
                
                
                
                
</script>

@endpush