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
                    </div>


                    <div class="card-body">
                        @csrf
                        <div class="form-group  justify-content-center">

                            <label for="">Subir Imagen</label>
                            <hr>
                            <input type="file" name="imagenPrincipal" id="imagenPrincipal">
                            <div id="preview" class="row justify-content-center">
                                <img src="" alt="" height="200px" width="200px">
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label class="control-label">Nombre: </label>

                            <input type="text" name="nombre" id="nombre" required placeholder="Ingrese un Nombre"
                                class="form-control" />
                        </div>

                        <div class="form-group  ">
                            <label class="control-label">Detalle : </label>
                            <textarea type="text" class="form-control" aria-label="With textarea" name="detalle"
                                id="detalle"> </textarea>
                        </div>

                        <div class="form-group ">
                            <label class="control-label">Precio Unitario : </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control text-left" id="precioUnitario"
                                    name="precioUnitario" data-mask
                                    data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false,  'placeholder': '0'">

                            </div>


                        </div>




                    </div>

                    <div class="card-footer text-muted justify-content-center">
                        <input type="submit" name="action_button" id="action_button" class="btn btn-success"
                            value="Add" />

                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />


                    </div>
                </div>
            </form>

            <div id="recetas">

            </div>
            {{-- <div class="card text-left">
                    <div class="card-header">
                        
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                            </div>
                            <h3>Crear Recetas Para el Modelo</h3>
                        </div> --}}

            {{-- <div class="card-body">
                            checkbox 
                            <div class="form-group">
                                <form action="" name="formCheck" id="formCheck">
                                    
                                    <div class="form-group clearfix ">
                                        <label for="">Mostrar solo materia prima: </label>
                                        <div class="icheck-success d-inline">
                                            
                                            <input type="checkbox" id="cambiarIngrediente" name="cambiarIngrediente">
                                            <label for="cambiarIngrediente" id='labelOperacion'>
                                                
                                            </div>
                                        </label>
                                    </div>
                                    
                                </form>
                                
                                
                            </div>
                            
                            <div class=" row">
                                
                                <div class="form-group col">
                                    <label id='labelIngrediente'>Ingredientes : </label>
                                    
                                    <select class="select2" name="ingredientes" id="ingredientes"
                                    data-placeholder="Seleccione Un Modelo" style="width: 100%;">
                                    @if(sizeof($modelos)>0)
                                    @foreach ($modelos as $modelo)
                                    <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
            @endforeach

            @endif
            </select>
        </div>

        <div class="form-group col">
            <label>Cantidad : </label>
            <input class="form-control" type="number" name="cantidad" id="cantidad" style="width: 100%;">
        </div>
        <div class="form-group col">
            <label>Prioridad : </label>
            <input class="form-control" type="number" name="prioridad" id="prioridad" style="width: 100%;">
        </div>

        <div class="form-group col">
            <button type="button" name="filtrar" id="agregar_receta" class="btn btn-success btn-sm">Agregar</button>

        </div>
    </div>


    <div class="card-deck  " id="add_receta">

    </div>

</div> --}}

{{-- <div class="card-footer text-muted">
                    </div>
                </div> --}}
</div>
</div>
</div>
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('#action').val("Add");
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
    });
    
    //********************************************************************************* RECETAS*************************************8
    $('#agregar_receta').click(function(){
        if(($('#cantidad').val()!='' )&& ($('#prioridad').val()!='') &&($('#ingredientes option').length>0)){
            $('#add_receta').append(
            '<div class="form-group ">'
                +'<div class="card border-secondary "style="max-width: 18rem; ">'
                    + '<input type="hidden" name="tipo_lista" id="tipo_lista" />'
                    + '<input type="hidden" name="ingrediente_id" id="ingrediente_id" />'
                    +'<div class="card-header"> <h3 class="text-center">'+$('#ingredientes option:selected').text()+' </h3> </div>'
                    +'<img src="Agregar el enlace del modelo" class="card-img-top" alt="" height="200px" width="200px">'
                    +'<div class="card-body"> <div class="form-group"> <p>Cantidad: ' +$('#cantidad').val() +'</p> </div>'
                    +'<div class="form-group">  <p>  Prioridad : ' +$('#prioridad').val() +'</p> </div>'
                    // +'<div class="form-group">  <p>  Modificable : ' +$('#modificable option:selected').text() +'</p> </div>'
                    +'</div>'
                    +'<div class="card-footer"> </div></div></div>');
                    $("#ingredientes option:selected").remove();
                    $('#cantidad').val('');
                    $('#prioridad').val('');
                    // $('#modificable').index(0);
                }
                
            });
            
            //**************************************** cambiar a materia primas los ingredientes ********************************************
            $('#cambiarIngrediente').change(function()
            {
                
                var check=this.checked? 1:0;
                //   console.log(check);
                
                
                var url="{{route('modelo.cargarListaIngrediente',":id")}}";
                url=url.replace(':id',check);
                //*********************************Ajax cargar combobox desde un checkbox***********************************************************8
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
                        $('#ingredientes').append($('<option>', {
                            value: carga.id,
                            text: carga.nombre,
                        }));
                    });
                    $('#ingredientes').index(0);
                    
                });
                
            });
            
            
            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                // var file = $("#imagenPrincipal")[0].files[0];
                // formData.append("file", file, file.name);
                
                $('#form_result').html('');
                
                if($('#action').val() == 'Add')
                {
                    
                    $.ajax({
                        url:"{{ route('modelo.store') }}",
                        method:"POST",
                        data: new FormData(this),
                        contentType: false,
                        cache:false,
                        processData: false,
                        dataType:"json",
                        success: function(json) {
                            console.log(json);
                             $('#action').val('Edit') ;
                             $('#action_button').val('Actualizar') ;
                             //agregamos los modelos
                            $('#recetas').append(json.receta);
                            $('#hidden_id').val(json.modelo.id);
                        }
                    });
                }else
                //boton action dentro del modal osea guardar se activa la actualizacion
                if($('#action').val() == "Edit")
                {
                    alert('edit');   
                    $.ajax({
                        url:"{{ route('materiaPrima.update') }}",
                        method:"POST",
                        data:new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType:"json",
                        success:function(data)
                        {
                            var html = '';
                            if(data.errors)
                            {
                                html = '<div class="alert alert-danger">';
                                    for(var count = 0; count < data.errors.length; count++)
                                    {
                                        html += '<p>' + data.errors[count] + '</p>';
                                    }
                                    html += '</div>';
                                }
                                
                                // if(data.success)
                                // {
                                    //     html = '<div class="alert alert-success">' + data.success + '</div>';
                                    //     //blanquea todo campos de entrda del modal
                                    //     // $('#sample_form')[0].reset();
                                    //     $('#data-table').DataTable().ajax.reload();
                                    // }
                                    $('#form_result').html(html);
                                    
                                }
                            });
                        }
                    });
                    
                    
                    
                    
</script>
@endpush