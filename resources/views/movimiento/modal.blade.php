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

                        <div class="form-group ">
                            <label class="control-label">Cantidad : </label>

                            <input type="text" class="form-control text-left" name="cantidad" id="cantidad"
                                placeholder="Cantidad de materia prima inicial" data-mask
                                data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">

                        </div>

                        <div class="form-group">
                            <label class="control-label ">Tipo de Movimiento : </label>
                            <select class="form-control select2 " id="tipoMovimiento_id" name="tipoMovimiento_id"
                                style="width: 100%;">
                                @if (sizeof($tipoMovimientos)>0)
                                @foreach ($tipoMovimientos as $tipoMovimiento)
                                <option value="{{$tipoMovimiento->id}}">{{$tipoMovimiento->nombre}}</option>
                                @endforeach
                                @endif
                            </select>

                        </div>

                        <div class="form-group">
                            <label class="control-label ">Proveedores : </label>
                            <select class="form-control select2 " id="proveedor_id" name="proveedor_id"
                                style="width: 100%;">

                                <option value="-1" selected disabled>NINGUNO</option>

                                @if (sizeof($proveedores)>0)

                                @foreach ($proveedores as $proveedor)
                                <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                                @endforeach
                                @endif
                            </select>

                        </div>

                        <div class="form-group">
                            <label class="control-label ">Materia Prima : </label>
                            <select class="form-control select2 " id="materiaPrima_id" name="materiaPrima_id"
                                style="width: 100%;">

                                @if (sizeof($materiaPrimas)>0)

                                @foreach ($materiaPrimas as $materiaPrima)
                                <option value="{{$materiaPrima->id}}">{{$materiaPrima->nombre}}</option>
                                @endforeach
                                @endif
                            </select>

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
                <form id="formDelete" action="{{route('movimiento.destroy')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    {{-- Paso el id de la materia  aborrar en boton_delete--}}
                    <input type="hidden" name="boton_delete" id="boton_delete">
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
        var indicePrecioUnitario=1;
        var indiceFecha=3;
        var indiceId=0;
        
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
        
        
        //la siguiente funcion recarga toda la tabla
        $('#reiniciar').click(function(){
            
            $('#filtro_precioUnitario').val('');
            $('#filtro_cantidad').val('');
            $('#filtro_fecha').val('');
            $.fn.dataTable.ext.search.pop(
            function( settings, data, dataIndex ) {
                return true ;
                
            }
            );
            table.draw() ;
        }) ;
        
        //****************************************** FILTRO DE LA TABLA**************************************************************
        function filtro_funcion(){
            var filtro_precioUnitarioMax = $('#filtro_precioUnitarioMax').val().trim().toUpperCase() ;
            var filtro_precioUnitarioMin = $('#filtro_precioUnitarioMin').val().trim().toUpperCase() ;
            var filtro_cantidad = $('#filtro_cantidad').val();
            var filtro_desde = $('#min').val();
            var filtro_hasta = $('#max').val();
            var filtro_id= $('#filtro_id').val();
            //se guardan la cantidad de filtros que se quieren realizar
            var cantidad_filtros=0;
            if(filtro_id!=''){
                cantidad_filtros++;
            }
            if((filtro_precioUnitarioMax!=0.00)&&(filtro_precioUnitarioMin!=0.00)){
                cantidad_filtros++;
            }else if((filtro_precioUnitarioMax!=0.00)){
                cantidad_filtros++;
            }else if((filtro_precioUnitarioMin!=0.00)){
                cantidad_filtros++;
            }
            if((filtro_desde !='') && (filtro_hasta!='') ){
                cantidad_filtros++;
            }
            
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
                    if(cantidad_filtros==4){

                        var min = moment(filtro_desde);
                        var max = moment(filtro_hasta) ;
                        
                        var d = data[indiceFecha];
                        var datearray = d.split("/");
                        var newdate =   datearray[2] + '/'+ datearray[1] + '/' + datearray[0] ;
                        var s = new Date(newdate)
                        var startDate = moment(s)
                        //comparamos el filtro entre la fechas
                        if((filtro_desde !='') && (filtro_hasta!='') ){
                            
                            (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) )? filtro_completos++ : 0 ;
                            
                        }
                        //comparamos los filtros del precio maximo y minimo
                        var precio=parseFloat(data[indicePrecioUnitario]);
                        if((filtro_precioUnitarioMax!=0.00)&&(filtro_precioUnitarioMin!=0.00)){
                            
                            (parseFloat(filtro_precioUnitarioMax) > precio )&&(precio >parseFloat(filtro_precioUnitarioMin))? filtro_completos++ : 0 ;
                            
                        }else if((filtro_precioUnitarioMax!=0.00)){
                            parseFloat(filtro_precioUnitarioMax) > precio ? filtro_completos++ : 0 ;
                            
                        }else if((filtro_precioUnitarioMin!=0.00)){
                            precio > parseFloat(filtro_precioUnitarioMin) ? filtro_completos++ : 0 ;
                        }
                        
                        filtro_id==data[indiceId]? filtro_completos++ :0;
                        
                        //si cummple con los tres filtro que guarde en la tabla la fila
                        return filtro_completos==cantidad_filtros? true:false;
                        
                    }else{
                        // si hay 1 o 2 filtros que compruebe todo
                    //filtro fechas **********************************************************************************************
                        var min = moment(filtro_desde);
                        var max = moment(filtro_hasta) ;
                        var d = data[indiceFecha];
                      
                        var datearray = d.split("/");
                        var newdate =   datearray[2] + '/'+ datearray[1] + '/' + datearray[0] ;
                        var s = new Date(newdate);
                        var startDate = moment(s);

                        //comparamos el filtro entre la fechas
                        if((filtro_desde !='') && (filtro_hasta!='') ){
                            (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) )? filtro_completos++ : 0 ;
                            
                        }
                        
                        //filtro de id ******************************************************************************   
                        if(filtro_id.length>0){
                            filtro_id==data[indiceId]? filtro_completos++ :0;
                        }
                        //filtro de precio unitario maximo y iminimo ****************************************************************
                        var precio=parseFloat(data[indicePrecioUnitario]);
                       

                        if((filtro_precioUnitarioMax!=0.00)&&(filtro_precioUnitarioMin!=0.00)){
                            (parseFloat(filtro_precioUnitarioMax) > precio )&&(precio >parseFloat(filtro_precioUnitarioMin))? filtro_completos++ : 0 ;
                            
                        }else if((filtro_precioUnitarioMax!=0.00)){
                            (parseFloat(filtro_precioUnitarioMax) > precio) ? filtro_completos++ : 0 ;
                        }else if((filtro_precioUnitarioMin!=0.00)){
                            precio > parseFloat(filtro_precioUnitarioMin) ? filtro_completos++ : 0 ;
                        } 
                        
                        return filtro_completos==cantidad_filtros? true:false;
                    }
                    
                    
                }
                $.fn.dataTable.ext.search.push( filtradoTabla )
            }
            
            table.draw();
        };
        
        
        //********************************Codigo para que busque en tiempo real el nombre********************************************************** 
        $('#filtro_id').keyup(function (){
            return filtro_funcion();
            
            
        });
        
        $('#filtro_precioUnitarioMin').keyup(function (){
            return filtro_funcion();    
        });
        $('#filtro_precioUnitarioMax').keyup(function (){
            return filtro_funcion();    
        });
        
        
        
        //la siguiente funcion filtra toda la tabla
        $('#filtrar').click(function(){
            return filtro_funcion();
        }) ;
        
        
        //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
        $('#create_record').click(function(){
            
            
            $('#form_result').html('');
            $("#sample_form").attr("action","{{route('movimiento.store')}}");
            $('.modal-title').text("Agregar Nuevo Modelo");
            $('#action_button').val("Agregar");
            $('#action').val("Add");
            
            $('#precioUnitario').val('');
            $('#cantidad').val('');
            
            $('#proveedor_id').index(0);
            $('#tipoMovimiento_id').index(0);
            $('#materiaPrima_id').index(0);
            
            $('#modelos').find('option').attr('selected',false).ready();
            // $('#imagenPrincipal').val('');
            $('#hidden_id').val('');
            
            $('#formModal').modal('show');
        });
        
       
        
        //el boton edit en el index que mostrara el modal
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $("#sample_form").attr("action","{{route('movimiento.update')}}");
            $('#form_result').html('');
            $.ajax({
                url:"/movimiento/"+id+"/edit",
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
                    //*******************************Cargar el selected de proveedor SELECT SIMPLE********************************************
                    $('#proveedor_id').find('option').remove();
                    html.totalProveedores.forEach(proveedor => {
                        $('#proveedor_id').append($('<option>', {
                            value: proveedor.id,
                            text: proveedor.nombre,
                        }));
                    });
                    $('#proveedor_id option[value="'+html.proveedor.id+'"]').attr('selected','selected');
                    //*******************************Cargar el selected de materia primas SELECT SIMPLE********************************************
                    $('#materiaPrima_id').find('option').remove();
                    html.totalMateriaPrimas.forEach(materiaPrima => {
                        $('#materiaPrima_id').append($('<option>', {
                            value: materiaPrima.id,
                            text: materiaPrima.nombre,
                        }));
                    });
                    $('#materiaPrima_id option[value="'+html.materiaPrima.id+'"]').attr('selected','selected');
                    //*******************************Cargar el selected de tipo movimiento SELECT SIMPLE********************************************
                    $('#tipoMovimiento_id').find('option').remove();
                    html.totalTipoMovimientos.forEach(tipoMovimiento => {
                        $('#tipoMovimiento_id').append($('<option>', {
                            value: tipoMovimiento.id,
                            text: tipoMovimiento.nombre,
                        }));
                    });
                    $('#tipoMovimiento_id option[value="'+html.tipoMovimiento.id+'"]').attr('selected','selected');
                    
                    //*********************************Cargar imagen***********************************************************
                    
                    let preview = document.getElementById('preview'),
                    image = document.createElement('img');
                    image.src='{{asset("/imagenes/materia_primas/")}}'+'/'+html.data.imagenPrincipal;
                    image.height='200';
                    image.width='200';
                    preview.innerHTML = '';
                    preview.append(image);
                    
                    
                    $('.modal-title').text("Editar Modelo");
                    $('#action_button').val("Editar");
                    $('#action').val("Edit");
                    $('#formModal').modal('show');
                    
                }
            })
        });
        
        
        var id;
        $(document).on('click', '.delete', function(){
            id = $(this).attr('id');
            $('#boton_delete').val(id);
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