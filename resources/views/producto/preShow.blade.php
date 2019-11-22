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

  .tree,
  .tree ul {
    margin: 0;
    padding: 0;
    list-style: none
  }

  .tree ul {
    margin-left: 1em;
    position: relative
  }

  .tree ul ul {
    margin-left: .5em
  }

  .tree ul:before {
    content: "";
    display: block;
    width: 0;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    border-left: 1px solid
  }

  .tree li {
    margin: 0;
    padding: 0 1em;
    line-height: 2em;
    color: #369;
    font-weight: 700;
    position: relative
  }

  .tree ul li:before {
    content: "";
    display: block;
    width: 10px;
    height: 0;
    border-top: 1px solid;
    margin-top: -1px;
    position: absolute;
    top: 1em;
    left: 0
  }

  .tree ul li:last-child:before {
    background: #fff;
    height: auto;
    top: 1em;
    bottom: 0
  }

  .indicator {
    margin-right: 5px;
  }

  .tree li a {
    text-decoration: none;
    color: #369;
  }

  .tree li button,
  .tree li button:active,
  .tree li button:focus {
    text-decoration: none;
    color: #369;
    border: none;
    background: transparent;
    margin: 0px 0px 0px 0px;
    padding: 0px 0px 0px 0px;
    outline: 0;
  }
</style>
@endsection

@section('content')
<div id="avisos">

</div>





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



          @foreach ($producto->materiaPrimaSeleccionadas as $seleccionada)
          <div class="form-group">

            <div class="row">
              <div class="form-group">


                <div class="col">

                  <label class="control-label "> {{$seleccionada->recetaHijo->modeloPadre->nombre}}:</label>
                </div>
              </div>
              <div class="form-group">


                <div class="col">

                  <input type="text" disabled name="" class="form-control"
                    value="{{$seleccionada->recetaHijo->materiaPrima->nombre}}">
                </div>
              </div>

            </div>

          </div>

          @endforeach








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
                height="{{(float)($sublimacion->alto)}}" width="{{(float)($sublimacion->ancho)}}">
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

<div id="verificarModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Confirmacion</h2>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="formVerificar" action="" method="GET" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <h4 align="center" style="margin:0;" id="mensajeVerificacion">¿Esta seguro que el producto se
            encuentra
            en condiciones de ser aprobado ?
          </h4>
          <div class="form-group  " id="aviso_oculto" style="display: none;">

            <label class="control-label">Describa el motivo del rechazo : </label>

            <input type="text" class="form-control text-left" name="aviso_detalle" id="aviso_detalle">
          </div>
          <hr>
          <div class="form-group  " id="confirmarProducto_oculto" style="display: none;">

            <div class="row justify-content-center">

              <div class="form-group">
                <label class="  ">
                  Imagen Del Producto Finalizado:

                </label>

              </div>
            </div>
            <div class="row justify-content-center">

              <div class="form-group">
                <div class=" " style="max-width: 10rem; ">
                  <div id="preview_producto" class=" row justify-content-center">
                    <img src="{{asset('/images/fondoBlanco.jpg')??'' }}" class="" height="150" width="180">
                  </div>

                  <div>
                    <label class="btn btn-default btn-file ">
                      Subir Imagen <i class="fas fa-upload ml-3" aria-hidden="true"></i>
                      <input type="file" id="" name="imagenProducto" style="display: none;"
                        onchange="cargar('preview_producto');" class="cargarImagen">
                    </label>
                  </div>

                </div>

              </div>
            </div>


          </div>
        </div>
        <div class="modal-footer justify-content-around">

          {{-- Paso el id de la materia  aborrar en button_delete--}}
          <input type="hidden" name="button_delete" id="button_delete">
          <button type="submit" name="ok_button" id="ok_button" class="btn btn-primary">OK</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
                                
                                $.fn.extend({
                                    treed: function (o) {
                                        
                                        var openedClass = 'glyphicon-minus-sign';
                                        var closedClass = 'glyphicon-plus-sign';
                                        
                                        if (typeof o != 'undefined'){
                                            if (typeof o.openedClass != 'undefined'){
                                                openedClass = o.openedClass;
                                            }
                                            if (typeof o.closedClass != 'undefined'){
                                                closedClass = o.closedClass;
                                            }
                                        };
                                        
                                        //initialize each of the top levels
                                        var tree = $(this);
                                        tree.addClass("tree");
                                        tree.find('li').has("ul").each(function () {
                                            var branch = $(this); //li with children ul
                                            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
                                            branch.addClass('branch');
                                            branch.on('click', function (e) {
                                                if (this == e.target) {
                                                    var icon = $(this).children('i:first');
                                                    icon.toggleClass(openedClass + " " + closedClass);
                                                    $(this).children().children().toggle();
                                                }
                                            })
                                            branch.children().children().toggle();
                                        });
                                        //fire event from the dynamically added icon
                                        tree.find('.branch .indicator').each(function(){
                                            $(this).on('click', function () {
                                                $(this).closest('li').click();
                                            });
                                        });
                                        //fire event to open branch if the li contains an anchor instead of text
                                        tree.find('.branch>a').each(function () {
                                            $(this).on('click', function (e) {
                                                $(this).closest('li').click();
                                                e.preventDefault();
                                            });
                                        });
                                        //fire event to open branch if the li contains a button instead of text
                                        tree.find('.branch>button').each(function () {
                                            $(this).on('click', function (e) {
                                                $(this).closest('li').click();
                                                e.preventDefault();
                                            });
                                        });
                                    }
                                });
                                
                                //Initialization of treeviews
                                
                                // $('#tree1').treed();
                                
                                // $('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
                                
                                $('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});
                                
                            
                            
                                
                                
                           
                                
                                function cambiarEstado(url){
                                    
                                    
                                    $.ajax({
                                        // async:false,    
                                        
                                        type: 'GET',
                                        url: url,
                                        dataType: 'json',
                                        success: function(array) {
                                            // console.log(data);
                                            var html='';
                                            if(array.errors)
                                            {
                                                html = '<div class="alert alert-danger"><button type="button" class="close" array-dismiss="alert">×</button><p>Corrige los siguientes errores:</p><ul>';
                                                    array.errors.forEach(error => {
                                                        html+= '<li>'+error + '</li>';
                                                    });
                                                    html+='</ul></div>';
                                                }else{
                                                    if(array.success){
                                                        html+='<div class="alert alert-success alert-block"><button type="button" class="close" array-dismiss="alert">×</button><strong>'+array.success+'</strong></div>';
                                                        
                                                    }
                                                    if(array.warning){
                                                        
                                                        html+='<div class="alert alert-warning alert-block"><button type="button" class="close" array-dismiss="alert">×</button><strong>'+array.warning+'</strong></div>';
                                                    }
                                                    
                                                    //si es verdadero
                                                    if(array.estado){
                                                        
                                                        var estadoNuevo='<h3><span class=""><a href="#">Producto: {{$producto->modelo->nombre}}</a></span>'
                                                        +'<span class="badge badge-warning">'+array.estado.nombre
                                                        +'</span></h3>';
                                                        
                                                        
                                                        $('#estadoTitulo').html(estadoNuevo);  
                                                        
                                                    }
                                                }
                                                $('#avisos').html(html);
                                                console.log(array);
                                            },
                                            error:function(){
                                                alert('error');
                                            }
                                        });

                                        $(document).on('click', '.close', function(){
                                                                                    
                                                                                    $('#avisos').html('');
                                                                                }); 
                                    }
                                    
                                    
</script>

@endpush