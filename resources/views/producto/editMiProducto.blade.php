@extends('admin_panel.index')
@section('style')
<style>
    .resize-drag {
        background-color: #29e;
        color: white;
        font-size: 20px;
        font-family: sans-serif;
        /* border-radius: 0%; */
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

    <form action="{{ route('producto.update',$producto->id) }}" method="POST" enctype="multipart/form-data"
        name="sample_form" id="sample_form">
        @csrf



        <div class="row ">

            &nbsp;&nbsp;&nbsp;<button type="submit" id="prueba2" class="btn btn-success">Actualizar Producto</button>
        </div>
        <br>
        <div class="row justify-content-around ">
            <div class="col-5">

                {{-- Otro cards --}}
                <div class="card text-left">

                    <div class="card-header">

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>

                        </div>
                        <h3 class="text-center">Materias Primas Seleccionadas</h3>
                    </div>
                    {{-- Se le pasa todos los modelos que tiene materia primas asociadas directamente en su recetas --}}
                    <input type="hidden" value="{{$cantidadModelos=0}}">
                    <div class="card-body">
                        <div class="row">

                            @if (!$recetasPadres->isEmpty())
                            <input type="hidden" value="{{$cantidadModelos=0}}">
                            @foreach ($producto->materiaPrimaSeleccionadas as $materiaSeleccionada)

                            {{-- Verifico que el modelo no tenga hijos modelos porque o sino sus materias primas serian estaticas --}}
                            @if ($materiaSeleccionada->recetaPadre->modeloHijo!=null)
                            <div class="form-group">



                                @if ($materiaSeleccionada->recetaPadre->modeloHijo->hijosModelos->isEmpty())
                                <label class="control-label ">
                                    {{$materiaSeleccionada->recetaPadre->modeloHijo->nombre}}:</label>
                                <input type="hidden" name="recetaPadre_{{$cantidadModelos}}"
                                    value="{{$materiaSeleccionada->recetaPadre->id}}">
                                <input type="hidden" name="materiaId_{{$cantidadModelos}}"
                                    value="{{$materiaSeleccionada->id}}">
                                <select class="form-control select2 " id="" name="recetaHijo_{{$cantidadModelos++}}">
                                    {{-- Se supone que el modelo hijo de la receta es un modelo sin modelos hijos --}}
                                    @foreach ($materiaSeleccionada->recetaPadre->modeloHijo->recetaPadre as $receta)
                                    @if ($materiaSeleccionada->recetaHijo->id == $receta->id)
                                    <option value="{{$receta->id}}" selected>{{$receta->materiaPrima->nombre}}</option>
                                    @else

                                    <option value="{{$receta->id}}">{{$receta->materiaPrima->nombre}}</option>
                                    @endif
                                    @endforeach
                                </select>

                                @else

                                @endif

                            </div>
                            @endif
                            &nbsp;&nbsp;
                            @endforeach


                            @endif
                        </div>
                        <div class="row">

                            <div class="form-group">

                                <label class="control-label "> Ingredientes estaticos:</label>

                            </div>
                        </div>
                        <div class="row">

                            @foreach ($modeloConMateriaPrimaEstatica as $modelo2)
                            @if (!$modelo2->hijosModelos->isEmpty())



                            @foreach ($modelo2->materiasPrimas as $materia)
                            <div class="form-group">

                                <input type="text" disabled value="{{$materia->nombre}}" class="form-control">

                            </div>
                            @endforeach




                            @endif
                            @endforeach
                        </div>



                        <input type="hidden" name="cantidadModelos" id="cantidadModelos" value="{{$cantidadModelos}}" />


                    </div>



                    <div class="card-footer text-muted justify-content-center">
                    </div>
                </div>
                {{-- Imagenes --}}
                <div class="card text-left">

                    <div class="card-header">

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>

                        </div>

                        <h3 class="text-center">Imagenes Seleccionada</h3>
                    </div>


                    <div class="card-body">


                        <div class="row">


                            <input type="hidden" value="{{$cantidadImagenes=0}}">
                            <input type="hidden" value="{{$cantidadImagenesSistema=0}}">
                            @foreach ($producto->sublimaciones as $sublimacion)
                            @if ($sublimacion!=null)

                            <div class="form-group "
                                id="add_imagen_{{$cantidadImagenes}}_componente_{{$sublimacion->componente->id}}"
                                style="margin-right:5%;">

                                <div class="col ">
                                    <div>
                                        @if ($sublimacion->nuevaImagen!=null)

                                        <input id="slider_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                                            class="range_5" type="text" name="range_5" value=""
                                            onchange="cambiarSlider(this,document.getElementById('imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}'),document.getElementById('nuevaImagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}'))">
                                        @else
                                        @if ($sublimacion->imagen !=null)

                                        <input
                                            id="slider_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}"
                                            class="range_5" type="text" name="range_5" value=""
                                            onchange="cambiarSlider(this,document.getElementById('imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}'),document.getElementById('nuevaImagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}'))">
                                        @endif

                                        @endif
                                    </div>
                                    <div id=" " style="max-width: 10rem;" class=" row justify-content-center">
                                        @if ($sublimacion->nuevaImagen!=null)
                                        <div id="'preview_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}">

                                            <img src="{{asset("/imagenes/sublimaciones/sinProcesar/".$sublimacion->nuevaImagen)??'' }}"
                                                class="bg-transparent" height="150" width="180"
                                                data-id="{{$cantidadImagenes}}"
                                                data-componente="{{$sublimacion->componente->id}}"
                                                data-imagen-sistema=" 0"
                                                id="nuevaImagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}">
                                        </div>


                                        <div>
                                            <label class="btn btn-default btn-file ">
                                                Modificar Imagen <i class="fas fa-upload ml-3" aria-hidden="true"></i>
                                                <input type="file"
                                                    id="file_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                                                    name="file_{{$cantidadImagenes}}_componente_{{$sublimacion->componente->id}}"
                                                    style="display: none;"
                                                    onchange="cargar({{$cantidadImagenes}},{{$cantidadComponente}});"
                                                    class="cargarImagen">
                                            </label>
                                        </div>
                                        <input type="hidden" value="{{$cantidadImagenes++}}">
                                        @else
                                        @if ($sublimacion->imagen !=null)
                                        <img src="
                                        {{asset('/imagenes/sublimaciones/'.$sublimacion->imagen->tipoImagen->nombre.'/'.$sublimacion->imagen->imagen )??'' }}"
                                            class="bg-transparent" height="150" width="180"
                                            data-id="{{$cantidadImagenesSistema}}"
                                            data-componente="{{$sublimacion->componente->id}} " data-imagen-sistema="1"
                                            id="nuevaImagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}">

                                        <input type="hidden" value="{{$cantidadImagenesSistema++}}">
                                        @endif
                                        @endif
                                    </div>
                                    <div>
                                        @if ($sublimacion->nuevaImagen!=null)


                                        @endif
                                    </div>

                                </div>


                            </div>
                            @endif
                            <input type="hidden" value="{{$cantidadComponente++}}">
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
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>

                        </div>
                        <input type="hidden" name="" id="" value="{{$cantidadComponente=0}}" />
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

                        <div align="center" id="componente_{{$cantidadComponente}}"
                            data-componente="{{$cantidadComponente}}" style="display:none;">

                            <div id="contenedor_{{$componente->id}}" class="resize-container"
                                style="background-image: url('{{asset("/imagenes/componentes/".$componente->imagenPrincipal)??'' }}'); background-position:center; ">

                                <input type="hidden" value="{{$cantidadImagenes=0}}">
                                <input type="hidden" value="{{$cantidadImagenesSistema=0}}">

                                @foreach ($producto->sublimaciones as $sublimacion)

                                @if ($sublimacion->componente->id==$componente->id)


                                @if ($sublimacion->nuevaImagen!=null)
                                {{-- <p>{{$sublimacion->id}}</p> --}}
                                @if ($sublimacion->forma !=null)
                                <img src="{{asset('/imagenes/sublimaciones/sinProcesar/'.$sublimacion->nuevaImagen)??'' }}"
                                    class="resize-drag bg-transparent"
                                    id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                                    height="{{(float)($sublimacion->alto)}}" width="{{(float)($sublimacion->ancho)}}"
                                    style="border-radius: {{$sublimacion->forma}}%;" data-id="{{$cantidadImagenes}}"
                                    data-componente="{{$cantidadComponente}}" data-imagen-sistema=" 0"
                                    data-x="{{(float) ($sublimacion->posX ?? 0)}}"
                                    data-y="{{(float) ($sublimacion->posY ?? 0)}}">
                                @else
                                <img src="{{asset('/imagenes/sublimaciones/sinProcesar/'.$sublimacion->nuevaImagen)??'' }}"
                                    class="resize-drag bg-transparent"
                                    id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                                    height="{{(float)($sublimacion->alto)}}" width="{{(float)($sublimacion->ancho)}}"
                                    data-x="{{(float) ($sublimacion->posX)}}" data-y="{{(float) ($sublimacion->posY)}}"
                                    style=" border-radius: {{0}}%;" data-id="{{$cantidadImagenes}}"
                                    data-componente="{{$cantidadComponente}}" data-imagen-sistema=" 0">
                                @endif


                                <input type="hidden"
                                    name="imagen_{{$cantidadImagenes}}_componente_{{$sublimacion->componente->id}}_posX"
                                    id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posX"
                                    value="{{$sublimacion->posX}}" />
                                <input type="hidden"
                                    name="imagen_{{$cantidadImagenes}}_componente_{{$sublimacion->componente->id}}_posY"
                                    id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_posY"
                                    value="{{$sublimacion->posY}}" />
                                <input type="hidden"
                                    name="imagen_{{$cantidadImagenes}}_componente_{{$sublimacion->componente->id}}_alto"
                                    id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_alto"
                                    value="{{$sublimacion->alto}}" />
                                <input type="hidden"
                                    name="imagen_{{$cantidadImagenes}}_componente_{{$sublimacion->componente->id}}_ancho"
                                    id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_ancho"
                                    value="{{$sublimacion->ancho}}" />
                                <input type="hidden"
                                    name="imagen_{{$cantidadImagenes}}_componente_{{$sublimacion->componente->id}}_forma"
                                    id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_forma"
                                    value="{{$sublimacion->forma}}" />
                                <input type="hidden"
                                    name="imagen_{{$cantidadImagenes}}_componente_{{$sublimacion->componente->id}}_sublimacion"
                                    id="imagen_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}_sublimacion"
                                    value="{{$sublimacion->id}}" />
                                <input type="hidden" value="{{$cantidadImagenes++}}">

                                @else
                                @if ($sublimacion->imagen!=null)
                                <img src="{{asset('/imagenes/sublimaciones/'.$sublimacion->imagen->tipoImagen->nombre.'/'.$sublimacion->imagen->imagen )??'' }}"
                                    class="resize-drag bg-transparent"
                                    id="imagen_sistema_{{$cantidadImagenes}}_componente_{{$cantidadComponente}}"
                                    height="{{(float)($sublimacion->alto)}}" width="{{(float)($sublimacion->ancho)}}"
                                    style="border-radius: {{$sublimacion->forma}}%;"
                                    data-x="{{(float) ($sublimacion->posX)}}" data-y="{{(float) ($sublimacion->posY)}}"
                                    data-id="{{$cantidadImagenesSistema}}" data-componente="{{$cantidadComponente}}"
                                    data-imagen-sistema="1">

                                <input type="hidden"
                                    name="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$sublimacion->componente->id}}_id"
                                    id="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}_id"
                                    value="{{$sublimacion->imagen_id}}" />
                                <input type="hidden"
                                    name="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$sublimacion->componente->id}}_posX"
                                    id="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}_posX"
                                    value="{{$sublimacion->posX}}" />
                                <input type="hidden"
                                    name="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$sublimacion->componente->id}}_posY"
                                    id="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}_posY"
                                    value="{{$sublimacion->posY}}" />
                                <input type="hidden"
                                    name="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$sublimacion->componente->id}}_alto"
                                    id="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}_alto"
                                    value="{{$sublimacion->alto}}" />
                                <input type="hidden"
                                    name="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$sublimacion->componente->id}}_ancho"
                                    id="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}_ancho"
                                    value="{{$sublimacion->ancho}}" />
                                <input type="hidden"
                                    name="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$sublimacion->componente->id}}_forma"
                                    id="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}_forma"
                                    value="{{$sublimacion->forma}}" />
                                <input type="hidden"
                                    name="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$sublimacion->componente->id}}_sublimacion"
                                    id="imagen_sistema_{{$cantidadImagenesSistema}}_componente_{{$cantidadComponente}}_sublimacion"
                                    value="{{$sublimacion->id}}" />
                                <input type="hidden" value="{{$cantidadImagenesSistema++}}">


                                @endif
                                @endif


                                @endif
                                @endforeach

                            </div>

                        </div>
                        <input type="hidden" id="cantidadImagenes_{{$cantidadComponente}}"
                            name="cantidadImagenes_{{$componente->id}}" class="cantidadImagenes_x"
                            value="{{$cantidadImagenes}}" />
                        <input type="hidden" id="cantidadImagenes_sistema_{{$cantidadComponente}}"
                            name="cantidadImagenes_sistema_{{$componente->id}}" class="cantidadImagenes_x"
                            value="{{$cantidadImagenesSistema}}" />
                        <input type="hidden" value="{{$cantidadComponente++}}">


                        @endforeach


                    </div>



                    <div class="card-footer text-muted justify-content-center">
                    </div>
                </div>

            </div>


        </div>
    </form>
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
                $('#componentes').prop('selectedIndex', 0);                    
                $('.tipoImagenSelect').prop('selectedIndex', 0);                    

             
                
                $('.range_5').ionRangeSlider({
                    min     : 0,
                    max     : 100,
                    type    : 'single',
                    step    : 1,
                    postfix : ' %',
                    prettify: false,
                    hasGrid : true
                });
                
            });
            
            interact('.resize-drag')
            .draggable({
                onmove: window.dragMoveListener,
                modifiers: [
                interact.modifiers.restrictRect({
                    restriction: 'parent'
                })
                ]
            })
            .resizable({
                // resize from all edges and corners
                edges: { left: true, right: true, bottom: true, top: true },
                
                modifiers: [
                // keep the edges inside the parent
                interact.modifiers.restrictEdges({
                    outer: 'parent',
                    endOnly: false
                }),
                
                // minimum size
                interact.modifiers.restrictSize({
                    min: { width: 100, height: 50 }
                })
                ],
                
                inertia: true
            })
            .on('resizemove', function (event) {
                var idNumeroDeImagen= event.target.getAttribute('data-id');
                var idNumeroDeComponente= event.target.getAttribute('data-componente');
                var comprobacion= event.target.getAttribute('data-imagen-sistema');
                // console.log('comprobacion: '+comprobacion);
                console.log('data-id: '+event.target.getAttribute('data-id'));
                
                
                var target = event.target
                var x = (parseFloat(target.getAttribute('data-x')) || 0)
                var y = (parseFloat(target.getAttribute('data-y')) || 0)
                
                // update the element's style
                target.style.width = event.rect.width + 'px'
                target.style.height = event.rect.height + 'px'
                ancho=event.rect.width;
                alto=event.rect.height;
                //guardamos el ancho y el lato de la imagen
                if(comprobacion ==1){
                    document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_ancho').setAttribute('value',ancho);
                    document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_alto').setAttribute('value',alto);
                    
                }else{
                    
                    // document.getElementById('imagen_'+idNumeroDeImagen+'_alto').setAttribute('value',alto);
                    document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_ancho').setAttribute('value',ancho);
                    document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_alto').setAttribute('value',alto);
                }
                
                // translate when resizing from top or left edges
                x += event.deltaRect.left
                y += event.deltaRect.top
                
                target.style.webkitTransform = target.style.transform ='translate(' + x + 'px,' + y + 'px)'
                
                target.setAttribute('data-x', x)
                target.setAttribute('data-y', y)
                //mostrar conteneido en el bloque
                //   target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height)
                target.textContent = ''
                posx=x
                posy=y
                if(comprobacion ==1){
                    
                    document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posY').setAttribute('value',posy);
                    document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posX').setAttribute('value',posx);
                }else{
                    document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posY').setAttribute('value',posy);
                    document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posX').setAttribute('value',posx);
                    
                }
                
            });
            
            function dragMoveListener(event) {
                var idNumeroDeImagen= event.target.getAttribute('data-id');
                var idNumeroDeComponente= event.target.getAttribute('data-componente');
                var comprobacion= event.target.getAttribute('data-imagen-sistema');
                // console.log('Comprobacion: '+comprobacion+' Id Imagen: '+idNumeroDeImagen+' Id Componente: '+ idNumeroDeComponente);
                var target = event.target;
                // console.log($('#'+target.id+'_posX').val());
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
                var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
                var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy
                // translate the element
                target.style.webkitTransform =
                target.style.transform =
                'translate(' + x + 'px, ' + y + 'px)'
                
                // update the posiion attributes
                target.setAttribute('data-x', x)
                target.setAttribute('data-y', y)
                
                posx=x
                posy=y
                //guardamos en los hidden la posicion x y de la imagen
                // document.getElementById('imagen_'+idNumeroDeImagen+'_posX').setAttribute('value',posx);
                // document.getElementById('imagen_'+idNumeroDeImagen+'_posY').setAttribute('value',posy);
                if(comprobacion ==1){
                    document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posY').setAttribute('value',posy);
                    document.getElementById('imagen_sistema_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posX').setAttribute('value',posx);
                }else{
                    document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posY').setAttribute('value',posy);
                    document.getElementById('imagen_'+idNumeroDeImagen+'_componente_'+idNumeroDeComponente+'_posX').setAttribute('value',posx);
                    
                }
            }
            
            // this is used later in the resizing and gesture demos
            window.dragMoveListener = dragMoveListener;
            
            
            
            
            
            
            for (let indiceComponente = 0; indiceComponente < cantidadComponente; indiceComponente++) {
                cantidadImagenes=document.getElementById('cantidadImagenes_'+indiceComponente).value;
                cantidadImagenesSistema=document.getElementById('cantidadImagenes_sistema_'+indiceComponente).value;
                for (let index = 0; index < cantidadImagenesSistema; index++) {
                    imagen=document.getElementById('imagen_sistema_'+index+'_componente_'+indiceComponente);
                    if(imagen!=null)
                    {
                        
                        
                        if(($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_ancho').val()!=null)&&($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_ancho').val()!='')){
                            
                            // posy=parseFloat($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_posY').val());
                            ancho=imagen.style.width=parseFloat($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_ancho').val());
                            
                        }else{
                            ancho=  imagen.style.width=120+'px';
                        }
                        
                        if(($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_posX').val()!=null)&&($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_posX').val()!='')){
                            posx=parseFloat($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_posX').val());
                        }else{
                            posx=0;
                        }
                        
                        if(($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_posY').val()!=null)&&($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_posY').val()!='')){
                            posy=parseFloat($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_posY').val());
                        }else{
                            posy=0;
                        }
                        if(($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_alto').val()!=null)&&($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_alto').val()!='')){
                            alto= imagen.style.height=parseFloat($('#imagen_sistema_'+index+'_componente_'+indiceComponente+'_alto').val());
                        }else{
                            alto= imagen.style.height=50+'px';
                        }
                        
                        console.log('x: '+posx+' y: '+posy+' alto:'+alto +' ancho: '+ancho);
                        
                        imagen.style.transform = 'translate(' + posx + 'px, ' + posy + 'px)';
                    }
                    // document.getElementById('imagen_'+index+'_componente_'+indiceComponente).setAttribute('value', document.getElementById(''));
                    // document.getElementById('imagen_'+index+'_componente_'+indiceComponente+'_alto').setAttribute('value',alto);
                    
                    
                }
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
                    console.log(numeroComponente);
                    
                    document.getElementById("componente_"+numeroComponente).style.display='block';
                    
                    // text = select.options[select.selectedIndex].innerText; //El texto de la opción seleccionada
                    
                }
                
                $('#prueba2').click(function(){
                    
                    $('#cantidadImagenes').val(cantidadImagenes);
                    
                    console.log('pos x: '+$('#posX').val() +'\n pos y: '+$('#posY').val());
                });
                
            
                
                
                //*********************************************************cargar imagen en las sublimaciones**********************************
                function cargar(idImagen,componenteSeleccionado){
                    // Creamos el objeto de la clase FileReader
                    
                    let reader = new FileReader();
                    // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                    reader.readAsDataURL(this.event.target.files[0]);
                    
                    // Le decimos que cuando este listo ejecute el código interno
                    reader.onload = function(){
                        // image = document.createElement('img');
                        image = document.getElementById( 'imagen_'+idImagen+'_componente_'+componenteSeleccionado);
                        image.src = reader.result;
                        document.getElementById('nuevaImagen_'+idImagen+'_componente_'+componenteSeleccionado).src=image.src;
                       
                    };
                };
                
                
                
                function cambiarSlider(idSlider,idImagen,idDise){
                    idImagen.style="border-radius: "+   idSlider.value +'%;' ;
                    idDise.style="border-radius: "+   idSlider.value +'%;' ;
                    document.getElementById(idImagen.id+'_forma').value=idSlider.value;
                    // console.log(idSlider.value);
                    
                }     
                
                
                
                
                
</script>

@endpush