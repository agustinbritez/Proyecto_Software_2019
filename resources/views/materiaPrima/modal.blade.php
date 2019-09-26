 
 <div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title"> TITULO</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" >Nombre: </label>
                        <div class="col-md-8">
                            <input type="text" name="nombre" id="nombre" placeholder="Ingrese un Nombre" class="form-control" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4">Detalle : </label>
                        <div class="col-md-8">
                            <textarea type="text" class="form-control" aria-label="With textarea" name="detalle" id="detalle" > </textarea>
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4">Cantidad : </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad de materia prima inicial">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4">Precio Unitario : </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="precioUnitario" id="precioUnitario" placeholder="Valor de la materia prima por unidad">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label ">Medida Asignada:  : </label>
                        <label class="" name="medidaSeleccionada" id="medidaSeleccionada"> </label>
                        
                        <div class="col-md-8">
                            
                            <select class="form-control select2 " id="medida_id" name="medida_id">
                                @if (!empty($medidas))
                                
                                 @foreach ($medidas as $medida)
                                <option value="{{$medida->id}}" >{{$medida->nombre}}</option>  
                                @endforeach   
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group col">
                        <label>Modelos : </label>
                        <select class="select2" multiple="multiple" name="modelos[]" data-placeholder="Seleccione Un Modelo"
                                style="width: 100%;">
                                @if(!empty($modelos))
                                    @foreach ($modelos as $modelo)
                                    <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>  
                                    @endforeach
                                
                                @endif
                                
                          
                        </select>
                      </div>
                    
                    {{-- <div class="form-group">
                        <label for="exampleFormControlFile1">Subir Una Imagen</label>
                        <input type="file" class="form-control-file" id="imagenPrincipal">
                    </div> --}}
                    <br />
                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmacion</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">¿Esta seguro que desea borrarlo?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "{{ route('materiaPrima.index') }}",
            },
            type: 'GET',
            data:{filtro_medida:filtro_medida
                
            },
            columns:[
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'nombre',
                name: 'nombre'
            },
            {
                data: 'precioUnitario',
                name: 'precioUnitario'
            },
            {
                data: 'cantidad',
                name: 'cantidad'
            },
            {
                data: 'medida',
                name: 'medida'
            },
            {
                data: 'modelos',
                name: 'modelos',
                orderable: false
            },
           
            // {
                //   data: 'imagenPrincipal',
                //   name: 'imagenPrincipal'
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
                ]
            });
            
            //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
            $('#create_record').click(function(){
                $('#form_result').html('');
                $('.modal-title').text("Agregar Nueva Materia Prima");
                $('#action_button').val("Agregar");
                $('#action').val("Add");
                $('#formModal').modal('show');
                $('#nombre').val('');
                $('#detalle').val('');
                $('#precioUnitario').val('');
                $('#cantidad').val('');
                // $('#imagenPrincipal').val('');
                $('#hidden_id').val('');
            });
            //el boton edit en el index que mostrara el modal
            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url:"/materiaPrima/"+id+"/edit",
                    contentType: false,
                    cache:false,
                    processData: false,
                    dataType:"json",
                    success:function(html){
                        //el data es la variable que contiene todo los atributos del objeto que se paso por la ruta
                        $('#nombre').val(html.data.nombre);
                        $('#detalle').val(html.data.detalle);
                        $('#precioUnitario').val(html.data.precioUnitario);
                        $('#cantidad').val(html.data.cantidad);
                        $('#hidden_id').val(html.data.id);
                        $('#medidaSeleccionada').text( html.medida.nombre);
                        // $('#medida_id option').removeProp('selected');  
                        // $('#medida_id option').each(function () {
                        //     if ($(this).val() == html.data.medida_id) {
                        //         this.selected = true;
                                
                        //     }else{this.selected = false;} });
                            
                            // $('#medida_id option[value="'+html.data.medida_id+'"]').prop('selected',true);                                                                            
                            $('.modal-title').text("Editar Materia Prima");
                            $('#action_button').val("Editar");
                            $('#action').val("Edit");
                            $('#formModal').modal('show');
                            // alert("{{$medidas[0]->nombre}}");
                            // alert(data.medida.nombre);
                        }
                    })
                });
                
                
                $('#sample_form').on('submit', function(event){
                    event.preventDefault();
                    // var file = $("#imagenPrincipal")[0].files[0];
                    // formData.append("file", file, file.name);
                    $('#form_result').html('');
                    if($('#action').val() == 'Add')
                    {
                        
                        $.ajax({
                            url:"{{ route('materiaPrima.store') }}",
                            method:"POST",
                            data: new FormData(this),
                            contentType: false,
                            cache:false,
                            processData: false,
                            dataType:"json",
                            success:function(data)
                            {
                                //  toastr.error('Validation error!', 'No se pudo Añadir los datos<br>'+error, {timeOut: 0});    
                                
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
                                    if(data.success)
                                    {
                                        html = '<div class="alert alert-success">' + data.success + '</div>';
                                        $('#sample_form')[0].reset();
                                        $('#data-table').DataTable().ajax.reload();
                                    }
                                    $('#form_result').html(html);
                                }
                            })
                        }
                        
                        //boton action dentro del modal osea guardar se activa la actualizacion
                        if($('#action').val() == "Edit")
                        {
                            
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
                                        if(data.success)
                                        {
                                            html = '<div class="alert alert-success">' + data.success + '</div>';
                                            //blanquea todo campos de entrda del modal
                                            // $('#sample_form')[0].reset();
                                            $('#data-table').DataTable().ajax.reload();
                                        }
                                        $('#form_result').html(html);
                                        $('#medidaSeleccionada').text( data.medida.nombre);
                                    }
                                });
                            }
                        });
                        
                        
                        var id;
                        
                        $(document).on('click', '.delete', function(){
                            id = $(this).attr('id');
                            $('#ok_button').text('Ok')
                            $('.modal-title').text("Confirmacion");
                            $('#confirmModal').modal('show');
                        });
                        
                        $('#ok_button').click(function(){
                            $.ajax({
                                url:"materiaPrima/destroy/"+id,
                                beforeSend:function(){$('#ok_button').text('Eliminando...');},
                                success:function(data){
                                    setTimeout(function(){
                                        $('#confirmModal').modal('hide');
                                        $('#data-table').DataTable().ajax.reload();
                                    }, 0);
                                    
                                }
                            })
                        });
                        
                    });
                </script>
                
                