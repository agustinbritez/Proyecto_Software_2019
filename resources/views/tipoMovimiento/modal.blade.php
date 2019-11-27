<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">

                    <h4 class="modal-title"> TITULO</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>

                    </div>
                    <span id="form_result"></span>


                    <div class="form-group col">
                        <label class="control-label">Nombre: </label>
                        <input type="text" name="nombre" id="nombre" required placeholder="Ingrese un Nombre"
                            class="form-control" />
                    </div>

                    <div class="form-group col">
                        <label class="control-label">Detalle: </label>
                        <input type="text" name="detalle" id="detalle" required placeholder="Ingrese un mayor detalle"
                            class="form-control" />
                    </div>


                    <div class="form-group clearfix col">
                        <label for="">Operacion: </label>
                        <div class="icheck-success d-inline">

                            <input type="checkbox" checked id="operacion" name="operacion">
                            <label for="operacion" id='labelOperacion'>

                        </div>
                        </label>
                    </div>

                </div>
                <div class="modal-footer justify-content-around">
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
                <form id="formDelete" action="{{route('tipoMovimiento.destroy')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    {{-- Paso el id de la materia  aborrar en button_delete--}}
                    <input type="hidden" name="button_delete" id="button_delete">
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<script>
    var table=$('#data-table').DataTable({
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
            
        }
    });
    $(document).ready(function(){
        
        
        //la siguiente funcion recarga toda la tabla
        $('#reiniciar').click(function(){
            // $("#tipoMovimiento ").prop("selectedIndex", 0) ;
            
            $('#filtro_nombre').val('');
            $('#filtro_operacion').attr('checked',true);
            
            //  $('#filtro_documento').prop("selectedIndex", 0) ;
            $.fn.dataTable.ext.search.pop(
            function( settings, data, dataIndex ) {
                return true ;
                
            }
            );
            table.draw() ;
        }) ;
        
        
        //****************************************** FILTRO DE LA TABLA**************************************************************
        function filtro_funcion(){
            var filtro_nombre = $('#filtro_nombre').val().trim().toUpperCase() ;
            var filtro_operacion = $('#filtro_operacion option:selected').text().trim().toUpperCase();
            //se guardan la cantidad de filtros que se quieren realizar
            var cantidad_filtros=0;
            if((filtro_nombre!='')){
                cantidad_filtros++;
            }
            if((filtro_operacion!='')){
                cantidad_filtros++;
            }
            
            $.fn.dataTable.ext.search.pop(
            function( settings, data, dataIndex ) {
                //si retorna falso saca de la tabla
                return true ;
            });
            
            if(cantidad_filtros!=0){
                var filtro_completos=0;
                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){
                    
                    //si son todo los filtros que realice todas las acciones directamente
                    filtro_completos=0;
                    if(cantidad_filtros==2){
                       
                        (data[1].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
                        (data[2].toUpperCase().includes(filtro_operacion))? filtro_completos++ :0;
                        //si cummple con los tres filtro que guarde en la tabla la fila
                        return filtro_completos==cantidad_filtros? true:false;
                        
                    }else{
                        
                        if((filtro_nombre!='')){
                            (data[1].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
                            if(filtro_completos==cantidad_filtros){
                                return true;
                            }
                        }
                        if((filtro_operacion!='')){
                            (data[2].toUpperCase().includes(filtro_operacion))? filtro_completos++ :0;
                            if(filtro_completos==cantidad_filtros){
                                return true;
                            }
                        }
                        
                        
                        return false;
                    }
                    
                }
                $.fn.dataTable.ext.search.push( filtradoTabla );
            }
            table.draw();
            
            
        };
        
        
        $('#filtro_nombre').keyup(function (){
            return filtro_funcion();
            
        });
        
        $('#operacion').change(function(){
            
                        if(this.checked==true){
                            $('#labelOperacion').text('(Sumar)');
                        }else{
                            $('#labelOperacion').text('(Restar)');
                        }
                        
                    });
        
        //la siguiente funcion filtra toda la tabla
        $('#filtrar').click(function(){
            return filtro_funcion();
        }) ;
        
        
        //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
        $('#create_record').click(function(){
            $('#form_result').html('');
            $("#sample_form").attr("action","{{route('tipoMovimiento.store')}}");
            $('.modal-title').text("Agregar Nuevo Tipo Movimiento");
            $('#action_button').val("Agregar");
            $('#action').val("Add");
            $('#formModal').modal('show');
            $('#nombre').val('');
            $('#detalle').val('');
            $('#operacion').attr('checked',true);
            
            $('#hidden_id').val('');
        });
        
        
        //el boton edit en el index que mostrara el modal
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $("#sample_form").attr("action","{{route('tipoMovimiento.update')}}");
            $('#form_result').html('');
            $.ajax({
                url:"/tipoMovimiento/"+id+"/edit",
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(html){
                    //el data es la variable que contiene todo los atributos del objeto que se paso por la ruta
                    $('#nombre').val(html.data.nombre);
                    $('#detalle').val(html.data.detalle);
                    
                    if(html.data.operacion!=0){
                            $('#labelOperacion').text('(Sumar)');
                            $('#labelOperacion').prop('checked', true);
                        }else{
                            $('#labelOperacion').text('(Restar)');
                        }            
                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text("Editar Tipo Movimiento");
                    $('#action_button').val("Editar");
                    $('#action').val("Edit");
                    $('#formModal').modal('show');
                }
            })
        });
        
        
        
        var id;
        $(document).on('click', '.delete', function(){
            id = $(this).attr('id');
            $('#button_delete').val(id);
            $('#ok_button').text('Ok')
            $('.modal-title').text("Confirmacion");
            $('#confirmModal').modal('show');
        });
        
        $('#formDelete').on('submit',function(){
            $('#ok_button').text('Eliminando...')
        });
        
        
        
    });
    
    
</script>