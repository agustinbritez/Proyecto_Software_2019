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
        width: 120px;
        height: 50px;

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

@if ($modelo!=null)
<div class=" ">

    <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data" name="sample_form"
        id="sample_form">
        @csrf

        <div class="row ">

            &nbsp;&nbsp;&nbsp;<button type="submit" id="prueba2" class="btn btn-success">Crear Producto</button>
        </div>
        <br>

        <div class="row justify-content-around ">

            <div class="col-5">




                <input type="hidden" name="modelo_id" id="modelo_id" value="{{$modelo->id}}" />
                <div class="card text-left">

                    <div class="card-header">

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>

                        </div>
                        <h3 class="text-center">Diseñe su producto</h3>
                    </div>
                    {{-- Se le pasa todos los modelos que tiene materia primas asociadas directamente en su recetas --}}
                    <div class="card-body">
                        <div class="row">

                            @if (!$hijoModelosConMateriaPrimas->isEmpty())

                            @foreach ($hijoModelosConMateriaPrimas as $modeloHijo)
                            @if ($modelo->id!=$modeloHijo->id)



                            <div class="form-group">



                                <label class="control-label "> {{$modeloHijo->nombre}}:</label>
                                <select class="form-control select2 " id="" name="modelo_{{$cantidadModelos++}}">
                                    @if (!$modeloHijo->materiasPrimas->isEmpty())
                                    @foreach ($modeloHijo->materiasPrimas as $materiaPrima)

                                    <option value="{{$materiaPrima->id}}">{{$materiaPrima->nombre}}</option>
                                    @endforeach
                                    @endif

                                </select>

                            </div>
                            &nbsp;&nbsp;
                            @endif


                            @endforeach

                            @endif
                            @if (!$modelo->materiasPrimas->isEmpty())


                            <div class="form-group">


                                <label class="control-label "> Ingredientes estaticos:</label>
                                @foreach ($modelo->materiasPrimas as $materia)

                                <input type="text" disabled value="{{$materia->nombre}}" class="form-control">

                                @endforeach



                            </div>
                            @endif

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

                        <h3 class="text-center">Imagen para sublimar</h3>
                    </div>


                    <div class="card-body">
                        @foreach ($modelo->componentes as $componente)
                        <div id="componente_{{$cantidadComponente}}_imagen" data-componente="{{$componente->id}}"
                            style="display:none;">

                            <div class="form-group">
                                <label class="control-label ">Seleccionar Tipo Imagen : </label>
                                <select class="tipoImagenSelect form-control select2 "
                                    onchange="cambiarGaleria('tipoImagen_componente_{{$cantidadComponente}}')"
                                    id="tipoImagen_componente_{{$cantidadComponente}}"
                                    data-componente="{{$componente->id}}"
                                    name="tipoImagen_componente_{{$cantidadComponente}}" style="width: 100%;">
                                    <option value="" selected disabled>Seleccione el Tipo Imagen</option>
                                    @if (sizeof($tipoImagenes)>0)

                                    @foreach ($tipoImagenes as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach
                                    @endif
                                </select>

                            </div>

                            <button type="button" id="agregarImagen_sistema" class="btn btn-success"
                                data-componente="{{$componente->id}}">Agregar
                                Imagen del Sistema</button>


                            <hr>
                            <div class="form-group  justify-content-center">

                                <label for="">Subir una nueva imagen</label>
                                <div class="row justify-content-around">
                                    <button type="button" id="agregarImagen_{{$componente->id}}"
                                        class="agregarImagen btn btn-success"
                                        data-componente="{{$componente->id}}">Agregar
                                        Imagen</button>
                                    <button type="button" data-componente="{{$componente->id}}"
                                        id="quitarImagen_{{$componente->id}}" class="quitarImagen btn btn-danger">Quitar
                                        Imagen</button>
                                </div>
                                <br>
                            </div>
                            <hr>
                            <div class="form-group  justify-content-center">

                                <label for="">Imagenes Agregadas</label>

                                <br>
                            </div>
                            {{-- Guardamos la la posicion x e y tambien el id de la imagen --}}



                            <div id="add_imagen_componente_{{$componente->id}}" class="row ">


                            </div>

                            <input type="hidden" value="{{$cantidadComponente++}}" />
                            <input type="hidden" name="cantidadImagenes_{{$componente->id}}"
                                id="cantidadImagenes_{{$componente->id}}" class="cantidadImagenes_x" value="0" />
                            <input type="hidden" name="cantidadImagenes_sistema_{{$componente->id}}"
                                id="cantidadImagenes_sistema_{{$componente->id}}" class="cantidadImagenes_x"
                                value="0" />



                        </div>

                        @endforeach
                    </div>
                    <input type="hidden" name="" id="" value="{{$cantidadComponente=0}}" />


                    <div class="card-footer text-muted justify-content-center">
                    </div>
                </div>

                {{-- Otro cards --}}


            </div>
            <div class="col-7">

                <div class="card text-left">

                    <div class="card-header">

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>

                        </div>
                        <h3 class="text-center">Elija una ubicacion para sublimar</h3>
                        <label class="control-label ">Seleccionar componente:</label>
                        <select class="form-control select2 " id="componentes" name="componentes" onchange="cambiar();">
                            <option value="" selected disabled>Seleccione el componente</option>
                            @foreach ($modelo->componentes as $componente)

                            <option value="{{$componente->id}}" data-componente="{{$cantidadComponente++}}">
                                {{$componente->nombre}}</option>
                            @endforeach

                        </select>
                        {{-- <button type="button" class="btn btn-flat btn-info" onclick="cambiar();">Elegir</button> --}}
                    </div>
                    <input type="hidden" name="" id="" value="{{$cantidadComponente=0}}" />

                    {{-- Se le pasa todos los modelos que tiene materia primas asociadas directamente en su recetas --}}
                    <div class="card-body">
                        @foreach ($modelo->componentes as $componente)
                        <div align="center" id="componente_{{$cantidadComponente}}"
                            data-componente="{{$cantidadComponente++}}" style="display:none;">

                            <div id="contenedor_{{$componente->id}}" class="resize-container"
                                style="background-image: url('{{asset("/imagenes/componentes/".$componente->imagenPrincipal)??'' }}'); background-position:center; ">

                                {{-- <img src="{{asset("/images/fondoBlanco.jpg")??'' }}" class="resize-drag"
                                id="resize-drag"> --}}

                            </div>

                        </div>
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
<div id="formModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">

            <div class="modal-header">
                <div class="text-center">

                    <h4 class="modal-title"> TITULO</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">



                <div id="add_imagenes_sistema" class="row">


                </div>

            </div>
            <div class="modal-footer ">

            </div>


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
                $(document).ready(function(){
                    $('.cantidadImagenes_x').val(0);
                    
                    $('#componentes').prop('selectedIndex', 0);                    
                    $('.tipoImagenSelect').prop('selectedIndex', 0);                    
                    
                    
                });
                //*********************************cambiar los componente**********************************8
                function cambiar(){
                    
                    var select = document.getElementById("componentes"); //El <select>
                        value = select.value; //El valor seleccionado
                        for (let index = 0; index < cantidadComponente; index++) {
                            document.getElementById("componente_"+index).style.display='none';
                            document.getElementById("componente_"+index+"_imagen").style.display='none';
                            
                        }
                        numeroComponente=select.options[select.selectedIndex].getAttribute('data-componente') ;
                        document.getElementById("componente_"+numeroComponente).style.display='block';
                        document.getElementById("componente_"+numeroComponente+"_imagen").style.display='block';
                        
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
                                                $('#contenedor_'+componenteSeleccionado).append('<img src="{{asset("/images/fondoBlanco.jpg")??'' }}" class="resize-drag" id="nuevaImagen_'+cantidadImagenes+'_componente_'+componenteSeleccionado+'" data-id="'+cantidadImagenes+'" data-componente="'+componenteSeleccionado+'" data-imagen-sistema=""0"">');
                                                
                                                
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
                                        function cambiarGaleria(id){
                                            
                                            var select= document.getElementById(id);
                                            var idTipo = select.value;
                                            
                                            var componenteSeleccionado=select.getAttribute('data-componente');
                                            var cantidadImagenesSistema=parseInt($('#cantidadImagenes_sistema_'+componenteSeleccionado).val());
                                            url2="{{route('tipoImagen.obtenerImagenes',":id")}}";
                                            
                                            url2=url2.replace(':id',idTipo);
                                            alert(url2);
                                            
                                            $.ajax({
                                                // async:false,
                                                
                                                type: 'GET',
                                                url: url2,
                                                success: function(data) {
                                                    console.log(data);
                                                    if(data!=null){
                                                        data['imagenes'].forEach(imagen => {
                                                            var urlSurce='{{asset("/imagenes/sublimaciones")}}'+'/'+data['tipoImagen'].nombre+'/'+ imagen.imagen;
                                                            var nuevaImagen='<div class="form-group " id="" style="margin-left:5%;">'
                                                                +'<div class="col " style="max-width: 10rem; ">'
                                                                    +'<div id="" class=" row justify-content-center">'
                                                                        +'<img src="" class="" height="150" width="180">'
                                                                        +'</div>'
                                                                        +'<div class=" row justify-content-center">'
                                                                            +'<button  type="button" class="agregarImagenSistema btn btn-default" data-imagen="'+imagen.id+'" data-ruta="'+urlSurce+'" data-componente="'+componenteSeleccionado+'">'
                                                                                +'Agregar Imagen'
                                                                                +'</button>'
                                                                                +'</div>'
                                                                                // +'<input type="hidden" name="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_posX" id="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_posX" value="" />'
                                                                                // +'<input type="hidden" name="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_posY" id="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_posY" value="" />'
                                                                                // +'<input type="hidden" name="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_alto" id="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_alto" value="" />'
                                                                                // +'<input type="hidden" name="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_ancho" id="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_ancho" value="" />'
                                                                                +'</div>'
                                                                                +'</div>';
                                                                                
                                                                                // $('#add_imagen_componente_'+componenteSeleccionado).append(nuevaImagen);
                                                                                $('#add_imagenes_sistema').append(nuevaImagen);
                                                                                // $('#contenedor_'+componenteSeleccionado).append('<img src="{{asset("/images/fondoBlanco.jpg")??'' }}" class="resize-drag" id="nuevaImagen_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'" data-id="'+cantidadImagenesSistema+'" data-componente="'+componenteSeleccionado+'">');
                                                                                cantidadImagenesSistema++;
                                                                                console.log(cantidadImagenesSistema);
                                                                            });
                                                                            $('#cantidadImagenes_sistema_'+componenteSeleccionado).val(cantidadImagenesSistema);
                                                                            
                                                                        }
                                                                    },
                                                                    error:function(){
                                                                        alert('error');
                                                                    }
                                                                });
                                                            }
                                                            $('#agregarImagen_sistema').click(function () {
                                                                
                                                                $('#formModal').modal('show');
                                                            });
                                                            
                                                            
                                                            //***************************************************************************************************************** 
                                                            $(document).on('click', '.agregarImagenSistema', function(){
                                                                var idImagen=$(this).attr('data-imagen');
                                                                var ruta=$(this).attr('data-ruta');
                                                                var componenteSeleccionado=$(this).attr('data-componente');
                                                                var cantidadImagenesSistema=parseInt($('#cantidadImagenes_sistema_'+componenteSeleccionado).val());
                                                                
                                                                var nuevaImagen='<div class="form-group " id="add_imagen_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'" style="margin-right:5%;">'
                                                                    +'<div class=" " style="max-width: 10rem; ">'
                                                                        +'<div id="preview_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'" class=" row justify-content-center">'
                                                                            +'<img src="'+ruta+'" class="" height="150" width="180">'
                                                                            +'</div>'
                                                                            +'<div>'
                                                                                // +'<label class="btn btn-default btn-file ">'
                                                                                    //     +'Subir Imagen <i class="fas fa-upload ml-3" aria-hidden="true"></i>'
                                                                                    //     +'<input type="file" id="'+cantidadImagenesSistema+'" name="file_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'" style="display: none;" onchange="cargar('+cantidadImagenesSistema+','+componenteSeleccionado+');"  class="cargarImagen">'
                                                                                    //     +'</label>'
                                                                                    +'</div>'
                                                                                    +'<input type="hidden" name="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_id" id="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_id" value="'+idImagen+'" />'
                                                                                    +'<input type="hidden" name="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_posX" id="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_posX" value="" />'
                                                                                    +'<input type="hidden" name="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_posY" id="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_posY" value="" />'
                                                                                    +'<input type="hidden" name="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_alto" id="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_alto" value="" />'
                                                                                    +'<input type="hidden" name="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_ancho" id="imagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'_ancho" value="" />'
                                                                                    +'</div>'
                                                                                    +'</div>';
                                                                                    
                                                                                    $('#add_imagen_componente_'+componenteSeleccionado).append(nuevaImagen);
                                                                                    $('#contenedor_'+componenteSeleccionado).append('<img src="'+ruta+'" class="resize-drag" id="nuevaImagen_sistema_'+cantidadImagenesSistema+'_componente_'+componenteSeleccionado+'" data-id="'+cantidadImagenesSistema+'" data-componente="'+componenteSeleccionado+'" data-imagen-sistema="1" >');
                                                                                    cantidadImagenesSistema++;
                                                                                    console.log(ruta);
                                                                                    
                                                                                    
                                                                                }); 
                                                                                
                                                                                // *****************************************Codigo para mover los componentes*******************************************************
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
                                                                                    console.log('comprobacion: '+comprobacion);
                                                                                    // console.log(event.target.getAttribute('data-id'));
                                                                                    
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

                                                                                    var target = event.target;
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