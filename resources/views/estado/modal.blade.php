<div id="formModal" class="modal fade" role="dialog">

    <div class="modal-dialog" role="document">
        <div class="modal-content ">

            <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-header">
                    @csrf

                    <h4 class="modal-title"> TITULO</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="avisos">
                        {{-- Se muestran los errores y alert --}}

                    </div>
                    <span id="form_result"></span>
                    <div class="container">

                        <div class="form-group  ">
                            <label class="control-label">Nombre: </label>

                            <input type="text" name="nombre" id="nombre" required placeholder="Ingrese un Nombre"
                                class="form-control" />
                        </div>


                    </div>
                </div>
                <div class="modal-footer justify-content-around">

                    <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>

                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="hidden_id" id="hidden_id" />

                </div>

            </form>
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
                <form id="formDelete" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    {{-- Paso el id de la materia  aborrar en materia_delete--}}
                    <input type="hidden" name="materia_delete" id="materia_delete">
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>




@push('scripts')
<script>
    var table= $('#data-table').DataTable({
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
    
    
    //mascaras******************************************************************************
    
    $('[data-mask]').inputmask();
    $(document).ready(function(){
                
                // parseFloat('21')<parseFloat('1000')?alert('verddero'+parseFloat('1000')):alert('false'+parseFloat('1000'));
                //variables globales 
                //indices del data table que uso para el filtro
                var indiceNombre=2;
                var indiceCantidad=4;
                var indiceModelos=6;
                var medidasGlobal;
                var modelosGlobal;
                const vacio='Cualquiera';
                // const vacio='-1';
                
              
                        
                        //la siguiente funcion recarga toda la tabla
                        $('#reiniciar').click(function(){
                            
                            $('#filtro_nombre').val('');
                            $('#filtro_cantidad').val('');
                           
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
                                    
                                    //****************************************** FILTRO DE LA TABLA**************************************************************
                                    function filtro_funcion(){
                                        var filtro_nombre = $('#filtro_nombre').val().trim().toUpperCase() ;
                                        
                                        var cantidad_filtros=0;
                                        if((filtro_nombre!='')){
                                            cantidad_filtros++;
                                        }
                                     
                                            $.fn.dataTable.ext.search.pop(
                                            function( settings, data, dataIndex ) {
                                                //si retorna falso saca de la tabla
                                                return true ;
                                            });
                                            
                                            //si no hay filtro que cargue todo
                                            if(cantidad_filtros>0){
                                                
                                                
                                                var filtro_completos=0;
                                                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){
                                                    
                                                    //si son todo los filtros que realice todas las acciones directamente
                                                    filtro_completos=0;
                                                    if(cantidad_filtros==1){
                                                  
                                                        (data[indiceNombre].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
                                                        //si cummple con los tres filtro que guarde en la tabla la fila
                                                        return filtro_completos==cantidad_filtros? true:false;
                                                        
                                                    }else{
                                                       
                                                                
                                                                if((filtro_nombre!='')){
                                                                    (data[indiceNombre].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
                                                                    if(filtro_completos==cantidad_filtros){
                                                                        return true;
                                                                    }
                                                                }
                                                                //retorna saca de la tabla porque no cumple con ningun filtro 
                                                                
                                                                return false;
                                                            }
                                                            
                                                        }
                                                        $.fn.dataTable.ext.search.push( filtradoTabla )
                                                    }
                                                    
                                                    table.draw();
                                                };
                                                
                                                
                                                //********************************Codigo para que busque en tiempo real el nombre********************************************************** 
                                                $('#filtro_nombre').keyup(function (){
                                                    return filtro_funcion();
                                                    
                                                });
                                                
                                                
                                                
                                                //la siguiente funcion filtra toda la tabla
                                                $('#filtrar').click(function(){
                                                    return filtro_funcion();
                                                }) ;
                                                
                                                
                                                //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
                                                $('#create_record').click(function(){
                                                    $('#add_estados').html(''); 
                                                    
                                                    $('#form_result').html('');
                                                    $("#sample_form").attr("action","{{route('estado.store')}}");
                                                    $('.modal-title').text("Crear Nuevo Estado");
                                                    $('#action_button').val("Crear");
                                                    $('#action').val("Add");
                                                    $('#nombre').val('');
                                                    $('#detalle').val('');
                                                    
                                                    $('#modelos').find('option').attr('selected',false).ready();
                                                    // $('#imagenPrincipal').val('');
                                                    $('#hidden_id').val('');
                                                    
                                                    $('#formModal').modal('show');
                                                });
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                $(document).on('click', '.delete', function(){
                                                    var id = $(this).attr('id');
                                                    $('#formDelete').attr('action','estado/destroy/'+id);
                                                    
                                                    $('#materia_delete').val(id);
                                                    $('#ok_button').text('Ok')
                                                    $('.modal-title').text("Confirmacion");
                                                    $('#confirmModal').modal('show');
                                                });
                                                
                                                $('#formDelete').on('submit',function(){
                                                    $('#ok_button').text('Eliminando...')
                                                });
                                                
                                              
                                                
                                                
                                            });
                                            //el boton edit en el index que mostrara el modal
                                            $(document).on('click', '.edit', function(){
                                                var id = $(this).attr('id');
                                               
                                                $("#sample_form").attr("action","estado/update/"+id);
                                                $('#form_result').html('');
                                                $('#add_estados').html(''); 
                                                
                                                
                                                var url="{{route('estado.edit',":id")}}";
                                                url=url.replace(':id',id);
                                                
                                                //*********************************Ajax cargar combobox desde un checkbox***********************************************************8
                                                //recibe un array de materia prima o de modelos depende del checkbox
                                                
                                                $.get(url,function(array){
                                                    console.log(array);
                                                    
                                                    $('#nombre').val(array['data'].nombre);
                                                    
                                                    $('#hidden_id').val(array['data'].id);
                                                });
                                                $('.modal-title').text("Editar Estado");
                                                $('#action_button').val("Actualizar");
                                                $('#action').val("Edit");
                                                $('#formModal').modal('show');
                                                
                                                
                                            });
                                            
                                            
                                            
                                            
                                            
                                            
</script>
@endpush