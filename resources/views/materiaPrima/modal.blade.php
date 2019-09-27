 
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
                            <input type="text" name="nombre" id="nombre" required placeholder="Ingrese un Nombre" class="form-control" />
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
                                @if (sizeof($medidas)>0)
                                
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
                        
                        
                        @if(sizeof($modelos)>0)
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
                <form id="formDelete" action="{{route('materiaPrima.destroy')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    {{-- Paso el id de la materia  aborrar en materia_delete--}}
                    <input type="hidden" name="materia_delete" id="materia_delete" >
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        // var table = $('#movimientos').DataTable();
        
        
        
        var table=$('#data-table').DataTable({
            "columnDefs": [
            // { "orderable": false, "targets":5  }
            // { "orderable": false,"targets":6  }
            ]
        });
        //la siguiente funcion recarga toda la tabla
        $('#reiniciar').click(function(){
            // $("#tipoMovimiento ").prop("selectedIndex", 0) ;
            
            $('#filtro_nombre').val('');
            $('#filtro_cantidad').val('');
            //  $('#filtro_modelo').prop("selectedIndex", 0) ;
            $.fn.dataTable.ext.search.pop(
            function( settings, data, dataIndex ) {
                if(1){
                    return true ;
                }
                return false ;
            }
            );
            table.draw() ;
        }) ;
        //la siguiente funcion filtra toda la tabla
        $('#filtrar').click(function(){
            
            var filtro_nombre = $('#filtro_nombre').val().trim() ;
            var filtro_cantidad = $('#filtro_cantidad').val();
            // alert(filtro_cant    idad.length);
            var filtro_modelo = $('#filtro_modelo option:selected').text();
            //se guardan la cantidad de filtros que se quieren realizar
            var cantidad_filtros=0;
            if((filtro_nombre!='')){
                cantidad_filtros++;
            }
            if(filtro_modelo!='Cualquiera'){
                cantidad_filtros++;
            }
            if(filtro_cantidad.length>0){
                cantidad_filtros++;
            }
            
            // console.log($('#filtro_modelo').text());
            
            //no olvidarme de volver a poner (pop) las filas
            //primero cargamo la tabla completa
            $.fn.dataTable.ext.search.pop(
            function( settings, data, dataIndex ) {
                //si retorna falso saca de la tabla
                return true ;
            });
            
            
            
            var filtro_completos=0;
            var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){
                //si no hay filtro que cargue todo
                if(cantidad_filtros==0){
                    return true;
                }
                //si son todo los filtros que realice todas las acciones directamente
                filtro_completos=0;
                if(cantidad_filtros==3){
                    var contieneModelo=data[5].indexOf(filtro_modelo);
                    //si contieneModelo es -1 no encontro en la cadena 
                    (contieneModelo>-1)? filtro_completos++ : 0;
                    (filtro_cantidad==data[3])? filtro_completos++ :0;
                    (filtro_nombre==data[1])? filtro_completos++ :0;
                    //si cummple con los tres filtro que guarde en la tabla la fila
                    return filtro_completos==cantidad_filtros? true:false;
                    
                }else{
                    // si hay 1 o 2 filtros que compruebe todo

                    //en data data[1] la columna 1 que es Nombre en data[0] esta la columna ID
                    //se coloco un if mas dentro de cada uno para optimizar
                    if((filtro_modelo!='Cualquiera')){
                        var contieneModelo=data[5].indexOf(filtro_modelo);
                        //si contieneModelo es -1 no encontro en la cadena 
                        (contieneModelo>-1)? filtro_completos++ : 0;
                        if(filtro_completos==cantidad_filtros){
                            return true;
                        }
                    }
                    if((filtro_cantidad.length>0)){
                        
                        (filtro_cantidad==data[3])? filtro_completos++ :0;
                        if(filtro_completos==cantidad_filtros){
                            return true;
                        }
                    }
                    if((filtro_nombre!='')){
                        (filtro_nombre==data[1])? filtro_completos++ :0;
                        if(filtro_completos==cantidad_filtros){
                            return true;
                        }
                    }
                    //retorna saca de la tabla porque no cumple con ningun filtro 
                    
                    return false;
                }
                
            }
            $.fn.dataTable.ext.search.push( filtradoTabla )
            table.draw();
            
        }) ;
        //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
        $('#create_record').click(function(){
            $('#form_result').html('');
            $("#sample_form").attr("action","{{route('materiaPrima.store')}}");
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
            $("#sample_form").attr("action","{{route('materiaPrima.update')}}");
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
                
                
                var id;
                
                $(document).on('click', '.delete', function(){
                    
                    id = $(this).attr('id');
                    
                    $('#materia_delete').val(id);
                    $('#ok_button').text('Ok')
                    $('.modal-title').text("Confirmacion");
                    $('#confirmModal').modal('show');
                });
                $('#formDelete').on('submit',function(){
                    $('#ok_button').text('Eliminando...')
                });
                // $(document).on('submit', 'ok_button', function(){
                    
                    //     $('#ok_button').text('Eliminando...')
                    // });
                    
                    
                    
                });
            </script>
            
            