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

                        <div class="form-group  ">
                            <label class="control-label">Detalle : </label>
                            <textarea type="text" class="form-control" aria-label="With textarea" name="detalle"
                                id="detalle"> </textarea>
                        </div>
                        <div class="form-group">
                            <label>Modelos : </label>
                            <select class="select2" multiple="multiple" id='modelos' name="modelos[]"
                                data-placeholder="Seleccione Un Modelo" style="width: 100%;">


                                @if(sizeof($modelos)>0)
                                @foreach ($modelos as $modelo)
                                <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
                                @endforeach

                                @endif


                            </select>
                        </div>

                        <div class="form-group" id="input_estados">
                            <label class="control-label">Flujo de Trabajo : </label>
                            <div class="row">

                                <div class="col-4">

                                    <label for="">Estado </label>
                                </div>
                            </div>
                            <div class="row ">

                                <div class="col">

                                    <select name="estado" id="estado" class="select2 form-control">

                                        @foreach ($estados as $estado)
                                        <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col" style="display: none;" id="botonAgregar">

                                    <button id="agregarEstado" type="button" class=" btn btn-primary btn-sm" data-id="">
                                        Agregar</button>
                                    <button id="quitarEstado" type="button" class="btn btn-danger btn-sm" data-id="">
                                        Quitar</button>
                                </div>
                            </div>
                            <br>
                            <div id="add_estados">

                                {{-- <span class="badge badge-success " id="estado_">Estado </span>
                                    <span><i class="fas fa-arrow-right"></i></span>
                                    <span class="badge badge-success " id="estado_">Estado &nbsp;</span> --}}

                            </div>
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
            // $.ajax({
                //     url:"/flujoTrabajo/parametros",
                //     contentType: false,
                //     cache:false,
                //     processData: false,
                //     dataType:"json",
                //     success:function(html){
                    //         medidasGlobal=html.totalMedidas;
                    //         modelosGlobal=html.totalModelos;
                    //     }
                    // });
                    
                    
                    
                    
                    
                    //la siguiente funcion recarga toda la tabla
                    $('#reiniciar').click(function(){
                        // $("#tipoMovimiento ").prop("selectedIndex", 0) ;
                        
                        $('#filtro_nombre').val('');
                        $('#filtro_cantidad').val('');
                        //cargar el select
                        // $('#filtro_modelo').find('option').remove();
                        // $('#filtro_modelo').append($('<option>', {
                            //     value: vacio,
                            //     text: 'Cualquiera',
                            // }));
                            // modelosGlobal.forEach(modelo => {
                                //     $('#filtro_modelo').append($('<option>', {
                                    //         value: modelo.id,
                                    //         text: modelo.nombre,
                                    //     }));
                                    //     $('#filtro_modelo').prop("selectedIndex", 0);
                                    // });
                                    
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
                                    // alert(filtro_cant    idad.length);
                                    // var filtro_modelo = $('#filtro_modelo option:selected').text();
                                    //se guardan la cantidad de filtros que se quieren realizar
                                    var cantidad_filtros=0;
                                    if((filtro_nombre!='')){
                                        cantidad_filtros++;
                                    }
                                    // if(filtro_modelo!=vacio){
                                        //     cantidad_filtros++;
                                        // }
                                        
                                        
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
                                                if(cantidad_filtros==1){
                                                    // var contieneModelo=data[indiceModelos].indexOf(filtro_modelo);
                                                    // //si contieneModelo es -1 no encontro en la cadena 
                                                    // (data[indiceModelos].toUpperCase().includes(filtro_modelo.toUpperCase()))? filtro_completos++ :0;
                                                    
                                                    (data[indiceNombre].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
                                                    //si cummple con los tres filtro que guarde en la tabla la fila
                                                    return filtro_completos==cantidad_filtros? true:false;
                                                    
                                                }else{
                                                    // si hay 1 o 2 filtros que compruebe todo
                                                    
                                                    //en data data[indiceNombre] la columna 1 que es Nombre en data[0] esta la columna ID
                                                    //se coloco un if mas dentro de cada uno para optimizar
                                                    // if((filtro_modelo!=vacio)){
                                                        //     var contieneModelo=data[indiceModelos].indexOf(filtro_modelo);
                                                        //     //si contieneModelo es -1 no encontro en la cadena 
                                                        //     // (contieneModelo>-1)? filtro_completos++ : 0;
                                                        //     (data[indiceModelos].toUpperCase().includes(filtro_modelo.toUpperCase()))? filtro_completos++ :0;
                                                        
                                                        //     if(filtro_completos==cantidad_filtros){
                                                            //         return true;
                                                            //     }
                                                            // }
                                                            
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
                                                
                                                document.getElementById('botonAgregar').style.display='none';
                                                $('#form_result').html('');
                                                $("#sample_form").attr("action","{{route('flujoTrabajo.store')}}");
                                                $('.modal-title').text("Crear nuevo flujo de trabajo");
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
                                                $('#formDelete').attr('action','flujoTrabajo/destroy/'+id);
                                                
                                                $('#materia_delete').val(id);
                                                $('#ok_button').text('Ok')
                                                $('.modal-title').text("Confirmacion");
                                                $('#confirmModal').modal('show');
                                            });
                                            
                                            $('#formDelete').on('submit',function(){
                                                $('#ok_button').text('Eliminando...')
                                            });
                                            
                                            $('#agregarEstado').click(function(){
                                                console.log('zz');
                                                var id=document.getElementById('agregarEstado').getAttribute('data-id');
                                                var idEstado=document.getElementById('estado').value;
                                                console.log('xxx');
                                                
                                                $('#add_estados').html(''); 
                                                
                                                // var url="flujoTrabajo/agregarEstado/"+id+'-'+idEstado;
                                                // url=url.replace(':id',id);
                                                //*********************************Ajax cargar combobox desde un checkbox***********************************************************8
                                                //recibe un array de materia prima o de modelos depende del checkbox
                                                $.ajax({
                                                    // async:false,
                                                    type: 'GET',
                                                    url: "flujoTrabajo/agregarEstado/"+id+'-'+idEstado,
                                                    success: function(array) {
                                                        console.log(array);
                                                        console.log(array['estadosDelFlujo'].length);
                                                        if( array['estadosDelFlujo'].length>0){
                                                            var html='';
                                                            if(array['estadoInicial']!=null){
                                                                html+= '<span class="badge badge-success " id="estado_">'+array['estadoInicial'].nombre+' </span><span><i class="fas fa-arrow-right"></i></span>';
                                                                array['estadosDelFlujo'].forEach(estado => {
                                                                    if(estado!=null){
                                                                        
                                                                        if((estado.id !=array['estadoInicial'].id)&&(estado.id != array['estadoFinal'].id) ){
                                                                            html+= '<span class="badge badge-info " id="estado_">'+estado.nombre+' </span>'
                                                                            +'<span><i class="fas fa-arrow-right"></i></span>'; 
                                                                        }
                                                                    }
                                                                });
                                                                if(array['estadoFinal'].id!=array['estadoInicial'].id){
                                                                    
                                                                    html+= '<span class="badge badge-danger " id="estado_">'+array['estadoFinal'].nombre+' </span>';
                                                                }
                                                                
                                                            }
                                                            
                                                            $('#add_estados').html(html);    
                                                        }
                                                    }
                                                });
                                                
                                                
                                            });
                                            
                                            $('#quitarEstado').click(function(){
                                                var id=document.getElementById('quitarEstado').getAttribute('data-id');
                                                $('#add_estados').html(''); 
                                                $.ajax({
                                                    // async:false,
                                                    type: 'GET',
                                                    url: "flujoTrabajo/quitarEstado/"+id,
                                                    success: function(array) {
                                                        if(array!=null){
                                                            if( array['estadosDelFlujo'].length>0){
                                                                var html='';
                                                                if(array['estadoInicial']!=null){
                                                                    html+= '<span class="badge badge-success " id="estado_">'+array['estadoInicial'].nombre+' </span><span><i class="fas fa-arrow-right"></i></span>';
                                                                    array['estadosDelFlujo'].forEach(estado => {
                                                                        if(estado!=null){
                                                                            
                                                                            if((estado.id !=array['estadoInicial'].id)&&(estado.id != array['estadoFinal'].id) ){
                                                                                html+= '<span class="badge badge-info " id="estado_">'+estado.nombre+' </span>'
                                                                                +'<span><i class="fas fa-arrow-right"></i></span>'; 
                                                                            }
                                                                        }
                                                                    });
                                                                    if(array['estadoFinal'].id!=array['estadoInicial'].id){
                                                                        
                                                                        html+= '<span class="badge badge-danger " id="estado_">'+array['estadoFinal'].nombre+' </span>';
                                                                    }
                                                                    
                                                                }
                                                                
                                                                $('#add_estados').html(html);    
                                                            }
                                                        }
                                                        
                                                    }
                                                });
                                            });
                                        });
                                        //el boton edit en el index que mostrara el modal
                                            $(document).on('click', '.edit', function(){
                                                var id = $(this).attr('id');
                                                document.getElementById('agregarEstado').setAttribute('data-id',id);
                                                document.getElementById('quitarEstado').setAttribute('data-id',id);
                                            
                                                $("#sample_form").attr("action","flujoTrabajo/update/"+id);
                                                document.getElementById('botonAgregar').style.display='block';
                                                $('#form_result').html('');
                                                $('#add_estados').html(''); 
                                                
                                                
                                                var url="{{route('flujoTrabajo.edit',":id")}}";
                                                url=url.replace(':id',id);
                                                
                                                //*********************************Ajax cargar combobox desde un checkbox***********************************************************8
                                                //recibe un array de materia prima o de modelos depende del checkbox
                                                
                                                $.get(url,function(array){
                                                    console.log(array);
                                                    
                                                    $('#nombre').val(array['data'].nombre);
                                                    $('#detalle').val(array['data'].detalle);
                                                    $('#hidden_id').val(array['data'].id);
                                                    //*******************************Cargar el selected de modelos SELECT MULTIPLE********************************************
                                                    
                                                    $('#modelos').find('option').remove();
                                                    console.log();
                                                    array['totalModelos'].forEach(modelo => {
                                                        $('#modelos').append($('<option>', {
                                                            value: modelo.id,
                                                            text: modelo.nombre,
                                                        }));
                                                    });
                                                    array['modelos'].forEach(modelo => {
                                                        $('#modelos option[value="'+modelo.id+'"]').attr('selected','selected');
                                                    });
                                                    
                                                    console.log(array['estadosDelFlujo'].length);
                                                    if( array['estadosDelFlujo'].length>0){
                                                        var html='';
                                                        if(array['estadoInicial']!=null){
                                                            html+= '<span class="badge badge-success " id="estado_">'+array['estadoInicial'].nombre+' </span><span><i class="fas fa-arrow-right"></i></span>';
                                                            array['estadosDelFlujo'].forEach(estado => {
                                                                if(estado!=null){
                                                                    
                                                                    if((estado.id !=array['estadoInicial'].id)&&(estado.id != array['estadoFinal'].id) ){
                                                                        html+= '<span class="badge badge-info " id="estado_">'+estado.nombre+' </span>'
                                                                        +'<span><i class="fas fa-arrow-right"></i></span>'; 
                                                                    }
                                                                }
                                                            });
                                                            if(array['estadoFinal'].id!=array['estadoInicial'].id){
                                                                
                                                                html+= '<span class="badge badge-danger " id="estado_">'+array['estadoFinal'].nombre+' </span>';
                                                            }
                                                            
                                                        }
                                                        
                                                        $('#add_estados').html(html);    
                                                    }
                                                    
                                                    
                                                });
                                                $('.modal-title').text("Editar Flujo de Trabajo");
                                                $('#action_button').val("Actualizar");
                                                $('#action').val("Edit");
                                                $('#formModal').modal('show');
                                                
                                                
                                            });
                                        
                                        
                                        
                                        
                                        
                                        
</script>
@endpush