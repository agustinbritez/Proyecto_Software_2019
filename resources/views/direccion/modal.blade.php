 
 <div id="formModal" class="modal fade" role="dialog">
    
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            
            <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-header">
                    
                    <h4 class="modal-title"> TITULO</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        
                        <ul></ul>
                        
                    </div>
                    <span id="form_result"></span>
                    @csrf
                    <div class="container">
                        <div class="form-group  ">
                            <label class="control-label" >Calle: </label>
                            
                            <input type="text" name="calle" id="calle" required placeholder="Ingrese la Calle" class="form-control" />
                        </div>
                        
                        <div class="form-group ">
                                <label class="control-label">Numero : </label>
                                <input type="text" class="form-control text-left" name="numero" id="numero"  data-mask data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">
                            </div>
                        
                        <div class="form-group  ">
                            <label class="control-label" >Codigo Posta: </label>
                            <input type="text" class="form-control text-left" name="codigoPosta" id="codigoPosta"  data-mask data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">
                        </div>
                        
                        <div class="form-group  ">
                            <label class="control-label" >Localidad: </label>
                            
                            <input type="text" name="localidad" id="localidad" required placeholder="Ingrese una Localidad" class="form-control" />
                        </div>
                        
                        <div class="form-group  ">
                            <label class="control-label" >Provincia: </label>
                            
                            <input type="text" name="provincia" id="provincia" required placeholder="Ingrese una Provincia" class="form-control" />
                        </div>
                        <div class="form-group  ">
                            <label class="control-label" >Pais: </label>
                            <input type="text" name="pais" id="pais" required placeholder="Ingrese un Pais" class="form-control" />
                        </div>
                        
                    <br />
                    
                </div>
            </div>
            <div class="modal-footer justify-content-around" >
                
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




@push('scripts')
<script>
    
    
    $(document).ready(function(){
        //variables globales 
        //indices del data table que uso para el filtro
        var indiceNombre=2;
        var indiceCantidad=4;
        var indiceModelos=6;
        var medidasGlobal;
        var modelosGlobal;
        const vacio='Cualquiera';
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
        
        //cargamos por primera vez las variables globales
        $.ajax({
            url:"/materiaPrima/parametros",
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            success:function(html){
                medidasGlobal=html.totalMedidas;
                modelosGlobal=html.totalModelos;
            }
        });
        
        
        
        
        
        //la siguiente funcion recarga toda la tabla
        $('#reiniciar').click(function(){
            // $("#tipoMovimiento ").prop("selectedIndex", 0) ;
            
            $('#filtro_nombre').val('');
            $('#filtro_cantidad').val('');
            //cargar el select
            $('#filtro_modelo').find('option').remove();
            $('#filtro_modelo').append($('<option>', {
                value: -1,
                text: vacio,
            }));
            modelosGlobal.forEach(modelo => {
                $('#filtro_modelo').append($('<option>', {
                    value: modelo.id,
                    text: modelo.nombre,
                }));
                $('#filtro_modelo').prop("selectedIndex", 0);
            });
            
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
        
        //****************************************** FILTRO DE LA TABLA**************************************************************
        function filtro_funcion(){
            var filtro_nombre = $('#filtro_nombre').val().trim().toUpperCase() ;
            var filtro_cantidad = $('#filtro_cantidad').val();
            // alert(filtro_cant    idad.length);
            var filtro_modelo = $('#filtro_modelo option:selected').text();
            //se guardan la cantidad de filtros que se quieren realizar
            var cantidad_filtros=0;
            if((filtro_nombre!='')){
                cantidad_filtros++;
            }
            if(filtro_modelo!=vacio){
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
            
            //si no hay filtro que cargue todo
            if(cantidad_filtros>0){
                
                
                var filtro_completos=0;
                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){
                    
                    //si son todo los filtros que realice todas las acciones directamente
                    filtro_completos=0;
                    if(cantidad_filtros==3){
                        var contieneModelo=data[indiceModelos].indexOf(filtro_modelo);
                        //si contieneModelo es -1 no encontro en la cadena 
                        (contieneModelo>-1)? filtro_completos++ : 0;
                        (filtro_cantidad==data[indiceCantidad])? filtro_completos++ :0;
                        (data[indiceNombre].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
                        //si cummple con los tres filtro que guarde en la tabla la fila
                        return filtro_completos==cantidad_filtros? true:false;
                        
                    }else{
                        // si hay 1 o 2 filtros que compruebe todo
                        
                        //en data data[indiceNombre] la columna 1 que es Nombre en data[0] esta la columna ID
                        //se coloco un if mas dentro de cada uno para optimizar
                        if((filtro_modelo!=vacio)){
                            var contieneModelo=data[indiceModelos].indexOf(filtro_modelo);
                            //si contieneModelo es -1 no encontro en la cadena 
                            (contieneModelo>-1)? filtro_completos++ : 0;
                            if(filtro_completos==cantidad_filtros){
                                return true;
                            }
                        }
                        if((filtro_cantidad.length>0)){
                            
                            (filtro_cantidad==data[indiceCantidad])? filtro_completos++ :0;
                            if(filtro_completos==cantidad_filtros){
                                return true;
                            }
                        }
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
                    
                    
                    $('#form_result').html('');
                    $("#sample_form").attr("action","{{route('materiaPrima.store')}}");
                    $('.modal-title').text("Agregar Nueva Materia Prima");
                    $('#action_button').val("Agregar");
                    $('#action').val("Add");
                    $('#nombre').val('');
                    $('#detalle').val('');
                    $('#precioUnitario').val('');
                    $('#cantidad').val('');
                    $('#modelos').find('option').attr('selected',false).ready();
                    $('#hidden_id').val('');
                    
                    $('#formModal').modal('show');
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
                            medidasGlobal=html.totalMedidas;
                            modelosGlobal=html.totalModelos;
                            //el data es la variable que contiene todo los atributos del objeto que se paso por la ruta
                            $('#nombre').val(html.data.nombre);
                            $('#detalle').val(html.data.detalle);
                            $('#precioUnitario').val(html.data.precioUnitario);
                            $('#cantidad').val(html.data.cantidad);
                            $('#hidden_id').val(html.data.id);
                            $('#medidaSeleccionada').text( html.medida.nombre);
                            //*******************************Cargar el selected de modelos SELECT MULTIPLE********************************************
                            
                            $('#modelos').find('option').remove();
                            html.totalModelos.forEach(modelo => {
                                $('#modelos').append($('<option>', {
                                    value: modelo.id,
                                    text: modelo.nombre,
                                }));
                            });
                            html.modelos.forEach(modelo => {
                                $('#modelos option[value="'+modelo.id+'"]').attr('selected','selected');
                            });
                            //*******************************Cargar el selected de Medidas SELECT SIMPLE********************************************
                            $('#medida_id').find('option').remove();
                            html.totalMedidas.forEach(medida => {
                                $('#medida_id').append($('<option>', {
                                    value: medida.id,
                                    text: medida.nombre,
                                }));
                            });
                            $('#medida_id option[value="'+html.medida.id+'"]').attr('selected','selected');
                            //*********************************Cargar imagen***********************************************************
                            
                            let preview = document.getElementById('preview'),
                            image = document.createElement('img');
                            image.src='{{asset("/imagenes/materia_primas/")}}'+'/'+html.data.imagenPrincipal;
                            image.height='200';
                            image.width='200';
                            preview.innerHTML = '';
                            preview.append(image);
                            
                            
                            $('.modal-title').text("Editar Materia Prima");
                            $('#action_button').val("Editar");
                            $('#action').val("Edit");
                            $('#formModal').modal('show');
                           
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
                
                
                
                
                
            });
        </script>
        @endpush
        
        
        