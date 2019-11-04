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
        
        /* This makes things *much* easier */
        box-sizing: border-box;
    }
    
    .resize-container {
        display: inline-block;
        width: 480px;
        height: 720px;
        background-repeat: no-repeat;
    }
</style>
@endsection

@section('content')



<br>


<div class=" ">
    
    
    <div class="row justify-content-around ">
        
        <div class="col">
            
            
            <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data" name="sample_form"
            id="sample_form">
            @csrf
            <input type="hidden" name="modelo_id" id="modelo_id" value="{{$modelo->id}}" />
            
            <div class="card text-left">
                
                <div class="card-header">
                    
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                            
                        </div>
                        
                        <h3 class="text-center">Imagen para sublimar</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label ">Seleccionar Tipo Imagen : </label>
                            <select class="form-control select2 " id="sublimacion_id" name="sublimacion_id"
                            style="width: 100%;">
                            @if (sizeof($tipoImagenes)>0)
                            
                            @foreach ($tipoImagenes as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                            @endforeach
                            @endif
                        </select>
                        
                    </div>
                    
                    
                    
                    <div class="form-group">
                        <label class="control-label ">Seleccionar Imagen : </label>
                        <select class="form-control select2 " id="imagen_id" name="imagen_id" style="width: 100%;"
                        class="selectpicker">
                        {{-- <option data-thumbnail="{{asset("/imagenes/modelos/".$imagen->imagen)??'' }}">
                            {{$imagen->nombre}}</option> --}}
                        </select>
                        
                    </div>
                    
                    
                    <div class="form-group  justify-content-center">
                        
                        <label for="">Subir una nueva imagen</label>
                        <div class="row justify-content-around">
                            <button type="button" id="agregarImagen" class="btn btn-success">Agregar Imagen</button>
                            <button type="button" id="quitarImagen" class="btn btn-danger">Quitar Imagen</button>
                        </div>
                        <br>
                    </div>
                    
                    {{-- Guardamos la la posicion x e y tambien el id de la imagen --}}
                    
                    
                    
                    <div id="add_imagen" class="row ">
                        {{-- <div class=" " style="max-width: 10rem; ">
                            <div id="preview" class="row justify-content-center">
                                <img src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg" class=""
                                height="150" width="180">
                            </div>
                            <div>
                                <label class="btn btn-default btn-file ">
                                    Subir Imagen <i class="fas fa-upload ml-3" aria-hidden="true"></i><input
                                    type="file" id="imagenNueva" name="imagenNueva" style="display: none;">
                                </label>
                            </div>
                            <input type="hidden" name="imagen_x_posX" id="imagen_x_posX" value="" />
                            <input type="hidden" name="imagen_x_posY" id="imagen_x_posY" value="" />
                            <input type="hidden" name="imagen_x_alto" id="imagen_x_alto" value="" />
                            <input type="hidden" name="imagen_x_ancho" id="imagen_x_ancho" value="" />
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}
                        
                        
                    </div>
                    
                    
                    
                </div>
                
                
                
                <div class="card-footer text-muted justify-content-center">
                    <button type="submit" id="prueba2" class="btn btn-success">Enviar posicion de imagen</button>
                </div>
            </div>
            
            {{-- Otro cards --}}
            <div class="card text-left">
                
                <div class="card-header">
                    
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                            
                        </div>
                        <h3 class="text-center">Personalice su producto</h3>
                    </div>
                    {{-- Se le pasa todos los modelos que tiene materia primas asociadas directamente en su recetas --}}
                    <div class="card-body">
                        @if (!$hijoModelosConMateriaPrimas->isEmpty())
                        
                        @foreach ($hijoModelosConMateriaPrimas as $modeloHijo)
                        
                        @if (!$modeloHijo->materiasPrimas->isEmpty())
                        @foreach ($modeloHijo->materiasPrimas as $materiaPrima)
                        
                        <div class="form-group">
                            
                            
                            
                            <label class="control-label "> {{$modeloHijo->nombre}}:</label>
                            <select class="form-control select2 " id="" name="modelo_{{$cantidadModelos++}}">
                                
                                <option value="{{$materiaPrima->id}}">{{$materiaPrima->nombre}}</option>
                                
                            </select>
                            
                        </div>
                        
                        @endforeach
                        @endif
                        
                        
                        @endforeach
                        
                        @endif
                        
                        <input type="hidden" name="cantidadModelos" id="cantidadModelos" value="{{$cantidadModelos}}" />
                        <input type="hidden" name="cantidadImagenes" id="cantidadImagenes" value="" />
                        
                        
                    </div>
                    
                    
                    
                    <div class="card-footer text-muted justify-content-center">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-7">
            
            <div class="card text-left">
                
                <div class="card-header">
                    
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                            
                        </div>
                        <h3 class="text-center">Personalice su producto</h3>
                    </div>
                    {{-- Se le pasa todos los modelos que tiene materia primas asociadas directamente en su recetas --}}
                    <div class="card-body">
                        <div align="center">
                            
                            <div id="contenedor" class=" resize-container" style="background-image: url('{{asset("/imagenes/modelos/".$modelo->imagenPrincipal)??'' }}');
                                ">
                                {{-- <img src="{{asset("/images/fondoBlanco.jpg")??'' }}" class="resize-drag"
                                id="resize-drag"> --}}
                                
                            </div>
                            
                        </div>
                        
                        
                    </div>
                    
                    
                    
                    <div class="card-footer text-muted justify-content-center">
                    </div>
                </div>
                
            </div>
            
            
        </div>
        
    </div>
    
    
    @endsection
    
    @section('htmlFinal')
    
    @endsection
    
    @push('scripts')
    <script>
        var posx;
        var poxy;
        var alto;
        var ancho;
        var cantidadImagenes=0;
        var limiteImagen=6;
        $(document).ready(function(){
            
            
            //cargar imagen local de forma dinamica
            
            
            
  
        });
        $('#prueba2').click(function(){
            
            $('#cantidadImagenes').val(cantidadImagenes);
            
            console.log('pos x: '+$('#posX').val() +'\n pos y: '+$('#posY').val());
        });
        $('#agregarImagen').click(function(){
            if(cantidadImagenes<limiteImagen){
                
                cantidadImagenes++; 
                var nuevaImagen='<div class="form-group " id="add_imagen_'+cantidadImagenes+'" style="margin-right:5%;">'
                    +'<div class=" " style="max-width: 10rem; ">'
                        +'<div id="preview_'+cantidadImagenes+'" class=" row justify-content-center">'
                            +'<img src="{{asset("/images/fondoBlanco.jpg")??'' }}" class="" height="150" width="180">'
                            +'</div>'
                            +'<div>'
                                +'<label class="btn btn-default btn-file ">'
                                    +'Subir Imagen <i class="fas fa-upload ml-3" aria-hidden="true"></i>'
                                    +'<input type="file" id="'+cantidadImagenes+'" name="file_'+cantidadImagenes+'" style="display: none;" onchange="cargar(this.id);"  class="cargarImagen">'
                                    +'</label>'
                                    +'</div>'
                                    +'<input type="hidden" name="imagen_'+cantidadImagenes+'_posX" id="imagen_'+cantidadImagenes+'_posX" value="" />'
                                    +'<input type="hidden" name="imagen_'+cantidadImagenes+'_posY" id="imagen_'+cantidadImagenes+'_posY" value="" />'
                                    +'<input type="hidden" name="imagen_'+cantidadImagenes+'_alto" id="imagen_'+cantidadImagenes+'_alto" value="" />'
                                    +'<input type="hidden" name="imagen_'+cantidadImagenes+'_ancho" id="imagen_'+cantidadImagenes+'_ancho" value="" />'
                                    +'</div>'
                                    +'</div>';
                                    
                                    $('#add_imagen').append(nuevaImagen);
                                    $('#contenedor').append('<img src="{{asset("/images/fondoBlanco.jpg")??'' }}" class="resize-drag" id="nuevaImagen_'+cantidadImagenes+'" data-id="'+cantidadImagenes+'">');
                                    
                                    
                                }
                            });
                            $('#quitarImagen').click(function(){
                                $('#add_imagen_'+cantidadImagenes).remove();
                                var ll=$('#nuevaImagen_'+cantidadImagenes).remove();
                                if(cantidadImagenes<=0){
                                    cantidadImagenes=0;
                                }else{
                                    
                                    cantidadImagenes--;
                                }
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
                                document.getElementById('imagen_'+idNumeroDeImagen+'_alto').setAttribute('value',alto);
                                document.getElementById('imagen_'+idNumeroDeImagen+'_ancho').setAttribute('value',ancho);
                                
                                // translate when resizing from top or left edges
                                x += event.deltaRect.left
                                y += event.deltaRect.top
                                
                                target.style.webkitTransform = target.style.transform ='translate(' + x + 'px,' + y + 'px)'
                                
                                target.setAttribute('data-x', x)
                                target.setAttribute('data-y', y)
                                //mostrar conteneido en el bloque
                                //   target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height)
                                target.textContent = ''
                            });
                            
                            function dragMoveListener(event) {
                                var idNumeroDeImagen= event.target.getAttribute('data-id');
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
                                document.getElementById('imagen_'+idNumeroDeImagen+'_posX').setAttribute('value',posx);
                                document.getElementById('imagen_'+idNumeroDeImagen+'_posY').setAttribute('value',posy);
                                
                            }
                            
                            // this is used later in the resizing and gesture demos
                            window.dragMoveListener = dragMoveListener;
                            function cargar(idImagen){
                                // Creamos el objeto de la clase FileReader
                                
                                let reader = new FileReader();
                                // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                                reader.readAsDataURL(this.event.target.files[0]);
                                
                                // Le decimos que cuando este listo ejecute el código interno
                                reader.onload = function(){
                                    let preview = document.getElementById('preview_'+idImagen);
                                    image = document.createElement('img');
                                    image.src = reader.result;
                                    image.class = 'img-fluid';
                                    image.height='150';
                                    image.width='180';
                                    preview.innerHTML = '';
                                    preview.append(image);
                                    // alert(image.src);
                                    
                                    document.getElementById('nuevaImagen_'+idImagen).src=image.src;
                                    
                                    // $('.resize-drag').src(image.src);
                                };
                            };
                            
                        </script>
                        
                        @endpush