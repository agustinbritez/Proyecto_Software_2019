@extends('admin_panel.index')


@section('content')



<br>

<div class="container">



    <div class="row">
        <div class="col">

            <form action="" method="POST" enctype="multipart/form-data" name="sample_form" id="sample_form">
                @csrf
                <div class="card text-left">

                    <div class="card-header">

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>

                        </div>
                        <h3>Crear Modelo</h3>
                        <div align="left">

                            <a href="{{route('modelo.create')}}" name="create_record" id="create_record"
                                class="btn btn-success btn-sm">Crear Nuevo Modelo</a>


                        </div>
                    </div>


                    <div class="card-body">
                        @if ($modificar)

                        <div align="right" style="display: block" id="mostrarComponente">
                            @else
                            <div align="right" style="display: none" id="mostrarComponente">

                                @endif

                                <button type="button" class="btn  btn-primary  btn-flat btn-sm" id="botonComponente">Ver
                                    Componentes
                                </button>
                            </div>
                            <div class="row">

                                <div class="col">
                                    <div class="form-group  justify-content-center">

                                        <label for="">Subir Imagen</label>
                                        <br>
                                        <input type="file" name="imagenPrincipal" id="imagenPrincipal">
                                        <div id="preview" class="row justify-content-center">
                                            <img src="{{asset("/imagenes/modelos/".$modelo->imagenPrincipal)??'' }}"
                                                alt="" height="200px" width="200px">
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group  ">
                                        <label class="control-label">Nombre: </label>

                                        <input type="text" name="nombre" id="nombre" required
                                            placeholder="Ingrese un Nombre" class="form-control"
                                            value="{{$modelo->nombre??''}}" />
                                    </div>

                                    <div class="form-group  ">
                                        <label class="control-label">Detalle : </label>
                                        <textarea type="text" class="form-control" aria-label="With textarea"
                                            name="detalle" id="detalle">{{$modelo->detalle??''}} </textarea>
                                    </div>

                                    <div class="form-group ">
                                        <label class="control-label">Precio Unitario : </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control text-left" id="precioUnitario"
                                                name="precioUnitario" data-mask value="{{$modelo->precioUnitario??''}}"
                                                data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false,  'placeholder': '0'">

                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="control-label ">Unidad de Medida : </label>
                                        <select class="form-control select2 " id="medida_id" name="medida_id"
                                            style="width: 100%;">
                                            @if (sizeof($medidas)>0)

                                            @foreach ($medidas as $medida)
                                            <option value="{{$medida->id}}">{{$medida->nombre}}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                    <div class="form-group clearfix ">
                                        <label for="">Disponible para la venta: </label>
                                        <div class="icheck-success d-inline">

                                            <input type="checkbox" id="venta" name="venta">
                                            <label for="venta" id='labelOperacion'>

                                        </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-muted justify-content-center">
                            @if ($modificar)
                            <input type="submit" name="action_button" id="action_button" class="btn btn-success"
                                value="Actualizar" />


                            <input type="hidden" name="action" id="action" value="Edit" />

                            @else
                            <input type="submit" name="action_button" id="action_button" class="btn btn-success"
                                value="Guardar" />
                            <input type="hidden" name="action" id="action" value="Add" />
                            @endif
                            <input type="hidden" name="hidden_id" id="hidden_id" value="{{$modelo->id??''}}" />
                        </div>
                    </div>
            </form>

            @if ($modificar)
            <div id="recetas" style="display: block">
                @else
                <div id="recetas" style="display: none">
                    @endif

                    <div class="card text-left">
                        <div id="avisos">
                            {{-- Se muestran los mensajes de los ingredientes --}}

                        </div>

                        <div class="card-header">

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                            <h3>Crear Recetas Para el Modelo</h3>
                        </div>

                        <div class="card-body">

                            <form action="" method="POST" enctype="multipart/form-data" name="form_recetas"
                                id="form_recetas">
                                @csrf
                                <div class="form-group">



                                    <div class="form-group clearfix ">
                                        <label for="">Mostrar solo materia prima: </label>
                                        <div class="icheck-success d-inline">

                                            <input type="checkbox" id="cambiarIngrediente" name="cambiarIngrediente">
                                            <label for="cambiarIngrediente" id='labelOperacion'>

                                        </div>
                                        </label>
                                    </div>




                                </div>

                                <div class=" row">

                                    <div class="form-group col">
                                        <label id='labelIngrediente'>Ingredientes : </label>

                                        <select class="select2" name="ingredientes" id="ingredientes"
                                            data-placeholder="Seleccione Un Modelo" style="width: 100%;">
                                            @if(sizeof($modelos)>0)

                                            @foreach ($modelos as $model2)
                                            <option value="{{$model2->id}}">
                                                {{$model2->nombre.' ('.$model2->medida->nombre.')' }}
                                            </option>
                                            @endforeach

                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col">
                                        <label>Cantidad : </label>
                                        <input class="form-control" type="number" name="cantidad" id="cantidad"
                                            style="width: 100%;">
                                    </div>
                                    <div class="form-group col">
                                        <label>Prioridad : </label>
                                        <input class="form-control" type="number" name="prioridad" id="prioridad"
                                            style="width: 100%;">
                                    </div>

                                    <div class="form-group col">
                                        <button type="submit" name="filtrar" id="agregar_receta"
                                            class="btn btn-success btn-sm">Agregar</button>
                                        <input type="hidden" name="hidden_id_modelo" id="hidden_id_modelo"
                                            value="{{$modelo->id??''}}" />
                                    </div>
                                </div>
                            </form>


                            <div class="card-deck  " id="add_receta">

                                @if (!$modelo->recetaPadre->isEmpty())
                                @foreach ($modelo->recetaPadre as $receta)
                                <div class="form-group ">
                                    <div class="card border-secondary " style="max-width: 18rem; ">
                                        <div class="card-header">
                                            <div class="card-tools">
                                                {{-- <button id="array.receta.id" type="button"
                                                class="delete btn btn-tool" data-card-widget="remove"><i
                                                class="fal fa-times-circle"></i></button> --}}
                                            </div>
                                            @if ($receta->modeloHijo!=null)
                                            <h3 class="text-center">{{$receta->modeloHijo->nombre}}</h3>

                                            @else
                                            <h3 class="text-center">{{$receta->materiaPrima->nombre}}</h3>
                                            @endif

                                        </div>
                                        @if ($receta->modeloHijo!=null)
                                        <img src="{{asset("/imagenes/modelos/".$receta->modeloHijo->imagenPrincipal)??'' }}"
                                            class="card-img-top" alt="" height="200px" width="200px">

                                        @else
                                        <img src="{{asset("/imagenes/materia_primas/".$receta->materiaPrima->imagenPrincipal)??'' }}"
                                            class="card-img-top" alt="" height="200px" width="200px">
                                        @endif

                                        <div class="card-body">

                                            <p>Cantidad: {{$receta->cantidad}} </p>
                                            @if ($receta->modeloHijo!=null)
                                            <p>Unidad de medida {{$receta->modeloHijo->medida->nombre}} </p>
                                            @else
                                            <p>Unidad de medida {{$receta->materiaPrima->medida->nombre}} </p>
                                            @endif
                                            <p> Prioridad : {{$receta->prioridad}} </p>

                                        </div>
                                        <div class="card-footer text-center">

                                            {{-- <button id="array.receta.id" type="button"
                                            class="delete btn btn-tool" data-card-widget="remove"><i
                                            class="fal fa-times-circle"></i></button> --}}
                                            <button type="button" name="delete" id="{{$receta->id}}"
                                                {{-- data-card-widget="remove" --}}
                                                class="delete btn btn-outline-danger btn-sm">Quitar</button>


                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @endif


                            </div>



                            <div class="card-footer text-muted">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    @endsection

    @section('htmlFinal')
    @include('modelo.componente')
    @endsection

    @push('scripts')

    <script>
        $(document).ready(function(){
                
                $('#ingredientes').index(0);
                //cargar imagen local de forma dinamica
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
                document.getElementById("imagenComponente").onchange = function(e) {
                    // Creamos el objeto de la clase FileReader
                    let reader = new FileReader();
                    
                    // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                    reader.readAsDataURL(e.target.files[0]);
                    
                    // Le decimos que cuando este listo ejecute el código interno
                    reader.onload = function(){
                        let preview = document.getElementById('previewComponente'),
                        image = document.createElement('img');
                        image.src = reader.result;
                        image.height='200';
                        image.width='200';
                        preview.innerHTML = '';
                        preview.append(image);
                    };
                }
                //mascaras******************************************************************************
                
                $('[data-mask]').inputmask();
                  //********************************************************************************* Componentes *************************************8
                  $('#componente_form').on('submit', function(event){
                                                        event.preventDefault();
                                                        if(($('#nombreComponente').val()!='' )){
                                                            // console.log(this);
                                                            $.ajax({
                                                                url:"{{ route('modelo.addComponente') }}",
                                                                method:"POST",
                                                                data: new FormData(this),
                                                                contentType: false,
                                                                cache:false,
                                                                processData: false,
                                                                dataType:"json",
                                                                success: function(array) {
                                                                    var html='';
                                                                    console.log(array);
                                                                    if(array.errors)
                                                                    {
                                                                        html = '<div class="alert alert-danger"><button type="button" class="close" array-dismiss="alert">×</button><p>Corrige los siguientes errores:</p><ul>';
                                                                            array.errors.forEach(error => {
                                                                                html+= '<li>'+error + '</li>';
                                                                            });
                                                                            html+='</ul></div>';
                                                                        }else{
                                                                            html='<div class="alert alert-success alert-block"><button type="button" class="close" array-dismiss="alert">×</button><strong>'+array.success+'</strong></div>';
                                                                        
                                                                                var nuevoComponente=
                                                                                '<div class="form-group">'
                                                                                    +'<div class="card" style="width: 15rem;">'
                                                                                            var ruta='';
                                                                                            
                                                                                            if(array.componente!=null){
                                                                                                if(array.componente.imagenPrincipal!=null){
                                                                                                    // ruta=dirname('/imagenes/modelos')+''+array.componente.imagenPrincipal;
                                                                                                    ruta='{{asset("/imagenes/componentes")}}'+'/'+array.componente.imagenPrincipal;
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                     nuevoComponente+='<img src="'+ruta+'" class="card-img-top" alt="...">'
                                                                                       +'<div class="card-body ">'
                                                                                          +'<h4 class="text-center">'+array.componente.nombre+'</h4>'
                                                                                      +'</div>'
                                                                                      +'<div class="card-footer text-center">'
                                                                                        +'<button type="button" name="deleteComponente" id="'+array.componente.id+'"'
                                                                                        +'class="deleteComponente btn btn-outline-danger btn-sm">Quitar</button>'
                                                                                      +'</div>'
                                                                                    +'</div>'
                                                                                  +'</div>';
                                                                                      
                                                                                  $('#componentes').append(nuevoComponente);  
                                                                                  $('#nombreComponente').val('');
                                                                                  }
                                                                                  $('#avisosModalComponente').html(html);
                                                                                  }
                                                                                        // error:function(){
                                                                                        //         alert('error');
                                                                                        //     }
                                                                                        });
                                                                                        
                                                                                    }                
                                                                                });  
                         $(document).on('click', '.deleteComponente', function(){
                        
                        var componente_id = $(this).attr('id');
                        $('#receta_delete').val(componente_id);
                        $('#formDelete').attr('action','/componente/destroy/'+componente_id+'');
                        $('#ok_button').text('Ok');
                        $('.modal-title').text("Confirmacion");
                        $('#formModal').modal('hide');
                        $('#confirmModal').modal('show');
                    });
                    
                    $('#formDelete').on('submit',function(){
                        $('#ok_button').text('Eliminando...');
                    });
            });
            
            
            
            
            //**************************************** cambiar a materia primas los ingredientes ********************************************
            $('body').on('change', '#cambiarIngrediente', function () {
                var check=this.checked? 1:0;
                //   console.log(check);
                
                
                
                var url="{{route('modelo.cargarListaIngrediente',":id")}}";
                url=url.replace(':id',check);
                //*********************************Ajax cargar combobox desde un checkbox***********************************************************8
                //recibe un array de materia prima o de modelos depende del checkbox
                
                $.get(url,function(data){
                    // console.log(data);
                    
                    if(check){
                        $('#labelIngrediente').text('Ingredientes (materia primas)');
                    }else{
                        $('#labelIngrediente').text('Ingredientes (modelos)');
                    }
                    //*******************************Cargar el selected de modelos SELECT SIMPLE********************************************
                    $('#ingredientes').find('option').remove();
                    data.forEach(carga => {
                        var idCarga=carga.id;
                        var url2='';
                        if(check){
                            url2="{{route('modelo.getMedidaMateriaPrima',":id")}}";
                        }else{
                            url2="{{route('modelo.getMedidaModelo',":id")}}";
                        }
                        url2=url2.replace(':id',idCarga);
                        $.get(url2,function(medida){
                            
                            $('#ingredientes').append($('<option>', {
                                value: carga.id,
                                text: carga.nombre +' ('+medida.nombre+') ',
                            }));
                        });
                        
                    });
                    $('#ingredientes').index(0);
                    
                });
                
            });  
            
            
            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                // var file = $("#imagenPrincipal")[0].files[0];
                // formData.append("file", file, file.name);
                
                $('#alert-aviso').html('');
                
                if($('#action').val() == 'Add')
                {
                    
                    var html='';
                    $.ajax({
                        url:"{{ route('modelo.store') }}",
                        method:"POST",
                        data: new FormData(this),
                        contentType: false,
                        cache:false,
                        processData: false,
                        dataType:"json",
                        success: function(json) {
                            if(json.errors)
                            {
                                html = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><p>Corrige los siguientes errores:</p><ul>';
                                    json.errors.forEach(error => {
                                        html+= '<li>'+error + '</li>';
                                    });
                                    html+='</ul></div>';
                                }else{
                                    html='<div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+json.success+'</strong></div>';
                                    
                                    $('#action').val('Edit') ;
                                    $('#action_button').val('Actualizar') ;
                                    //agregamos los modelos
                                    document.getElementById('recetas').style.display='block';
                                    document.getElementById('mostrarComponente').style.display='block';
                                    // $('#recetas'). (json.receta);
                                    $('#hidden_id').val(json.modelo.id);
                                    $('#hidden_id_modelo').val(json.modelo.id);
                                    $('#hidden_id_modelo_componente').val(json.modelo.id);
                                }
                                $('#alert-aviso').html(html);
                            }
                        });
                    }else
                    //boton action dentro del modal osea guardar se activa la actualizacion
                    if($('#action').val() == "Edit")
                    {
                        var html = '';
                        $.ajax({
                            url:"{{ route('modelo.update') }}",
                            method:"POST",
                            data:new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType:"json",
                            success:function(array)
                            {
                                console.log('adas');
                                if(array.errors)
                                {
                                    html = '<div class="alert alert-danger"><button type="button" class="close" array-dismiss="alert">×</button><p>Corrige los siguientes errores:</p><ul>';
                                        array.errors.forEach(error => {
                                            html+= '<li>'+error + '</li>';
                                        });
                                        html+='</ul></div>';
                                    }else{
                                        html='<div class="alert alert-success alert-block"><button type="button" class="close" array-dismiss="alert">×</button><strong>'+array.success+'</strong></div>';
                                        
                                        //mostramos el mensaje
                                        document.getElementById('recetas').style.display='block';
                                        document.getElementById('mostrarComponente').style.display='block';
                                        
                                        $('#hidden_id').val(array.modelo.id);
                                        $('#hidden_id_modelo').val(array.modelo.id);
                                        $('#hidden_id_modelo_componente').val(array.modelo.id);
                                    }
                                    $('#alert-aviso').html(html);
                                    
                                },
                            // error: function(){
                            //     alert('errors');
                            // }
                            });
                        }
                    }); 
                    
                    
                    
                    
                    $(document).on('click', '.delete', function(){
                        
                        var receta_id = $(this).attr('id');
                        $('#receta_delete').val(receta_id);
                        $('#formDelete').attr('action','/receta/destroy/'+receta_id+'');
                        $('#ok_button').text('Ok');
                        $('.modal-title').text("Confirmacion");
                        $('#confirmModal').modal('show');
                    });
                    
                    $('#formDelete').on('submit',function(){
                        $('#ok_button').text('Eliminando...');
                    });
                    
                    
                    
                    
                    //********************************************************************************* RECETAS*************************************8
                    $('#form_recetas').on('submit', function(event){
                        event.preventDefault();
                        if(($('#cantidad').val()!='' )&& ($('#prioridad').val()!='') &&($('#ingredientes option').length>0)){
                            // console.log(this);
                            $.ajax({
                                url:"{{ route('modelo.addRelation') }}",
                                method:"POST",
                                data: new FormData(this),
                                contentType: false,
                                cache:false,
                                processData: false,
                                dataType:"json",
                                success: function(array) {
                                    var html='';
                                    if(array.errors)
                                    {
                                        html = '<div class="alert alert-danger"><button type="button" class="close" array-dismiss="alert">×</button><p>Corrige los siguientes errores:</p><ul>';
                                            array.errors.forEach(error => {
                                                html+= '<li>'+error + '</li>';
                                            });
                                            html+='</ul></div>';
                                        }else{
                                            html='<div class="alert alert-success alert-block"><button type="button" class="close" array-dismiss="alert">×</button><strong>'+array.success+'</strong></div>';
                                            //si es verdadero
                                            if(array.agregar){
                                                
                                                
                                                var nuevaReceta='<div class="form-group ">'
                                                    +'<div class="card border-secondary " style="max-width: 18rem; ">'
                                                        +'<div class="card-header">';
                                                            if(array.hijoModelo!=null){
                                                                nuevaReceta+= '<h3 class="text-center">'+array.hijoModelo.nombre+'</h3>';     
                                                            }else if(array.hijoMateriaPrima!=null){
                                                                nuevaReceta+= '<h3 class="text-center">'+array.hijoMateriaPrima.nombre+'</h3>';     
                                                            }
                                                            nuevaReceta+= '</div>';
                                                            var ruta='';
                                                            var url2='';
                                                            var idCarga;
                                                            if(array.hijoModelo!=null){
                                                                if(array.hijoModelo.imagenPrincipal!=null){
                                                                    // ruta=dirname('/imagenes/modelos')+''+array.hijoModelo.imagenPrincipal;
                                                                    ruta='{{asset("/imagenes/modelos")}}'+'/'+array.hijoModelo.imagenPrincipal;
                                                                    
                                                                }
                                                                idCarga=array.hijoModelo.id;
                                                                console.log('hijo modelo '+array.hijoModelo.id);
                                                                url2="{{route('modelo.getMedidaModelo',":id")}}";
                                                            }else if(array.hijoMateriaPrima!=null){
                                                                if(array.hijoMateriaPrima.imagenPrincipal!=null){
                                                                    // ruta=dirname('/imagenes/modelos/')+''+array.hijoMateriaPrima.imagenPrincipal;
                                                                    
                                                                    ruta='{{asset("/imagenes/materia_primas")}}'+'/'+array.hijoMateriaPrima.imagenPrincipal;
                                                                }
                                                                idCarga=array.hijoMateriaPrima.id;
                                                                console.log('hijo materia prima '+array.hijoMateriaPrima.id);
                                                                url2="{{route('modelo.getMedidaMateriaPrima',":id")}}";
                                                            }
                                                            url2=url2.replace(':id',idCarga);
                                                            
                                                            
                                                            
                                                            nuevaReceta +='  <img src="'+ruta+'"class="card-img-top" alt="" height="200px" width="200px">'
                                                            
                                                            +'<div class="card-body">'
                                                                +'<p>Cantidad: '+array.receta.cantidad+' </p>';
                                                                var medidaNombre='Sin Medida';
                                                                //obtener la medida del ingrediente que se ingreso async ayuda a que espere por la medida
                                                                $.ajax({
                                                                    async:false,
                                                                    type: 'GET',
                                                                    url: url2,
                                                                    success: function(medida) {
                                                                        
                                                                        if(medida!=null){
                                                                            medidaNombre=medida.nombre;
                                                                        }
                                                                    }
                                                                });
                                                                
                                                                // $.get(url2,function(medida){
                                                                    //     medidaNombre=medida.nombre;
                                                                    //     console.log(medida);
                                                                    // });
                                                                    
                                                                    nuevaReceta +='<p> Unidad de medida : '+medidaNombre+' </p>';
                                                                    nuevaReceta +='<p> Prioridad : '+array.receta.prioridad+' </p>'
                                                                    +'</div>'
                                                                    +' <div class="card-footer text-center">'
                                                                        
                                                                        +'<button type="button" name="delete" id="'+array.receta.id+'"class="delete btn btn-outline-danger btn-sm">Quitar</button>'
                                                                        +'</div>'
                                                                        +'</div>'
                                                                        +'</div>';
                                                                        
                                                                        $('#add_receta').append(nuevaReceta);  
                                                                        
                                                                        $('#cantidad').val('');
                                                                        $('#prioridad').val('');
                                                                    }
                                                                }
                                                                $('#avisos').html(html);
                                                                console.log(array);
                                                                
                                                                
                                                            }
                                                            // error:function(){
                                                                //     alert('error');
                                                                // }
                                                            });
                                                            
                                                        }                
                                                    });    
                                                   
                                                                                
                                                                                $(document).on('click', '.close', function(){
                                                                                    
                                                                                    $('#avisos').html('');
                                                                                    $('#alert-aviso').html('');
                                                                                }); 
                                                                                
                                                                                $('#botonComponente').click(function(){
                                                                                    
                                                                                    $('#formModal').modal('show');

                                                                                });
                                                                                
    </script>
    @if ($message = Session::get('returnModal'))
    <script>
        $(document).ready(function(){
        $('#formModal').modal('show');

         });
    </script>
    @endif
    @endpush