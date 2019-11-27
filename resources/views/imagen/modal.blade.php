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
                            <label class="control-label">Nombre: </label>

                            <input type="text" name="nombre" id="nombre" required placeholder="Ingrese un Nombre"
                                class="form-control" />
                        </div>

                        <div class="form-group  justify-content-center">

                            <label for="">Subir Imagen</label>
                            <hr>
                            <input type="file" name="imagenPrincipal" id="imagenPrincipal">
                            <div id="preview" class="row justify-content-center">
                                <img src="" alt="" height="200px" width="200px">
                            </div>
                        </div>




                        <div class="form-group">
                            <label>Tipos de Imagen : </label>
                            <select class="select2" id='tipoImagen_id' name="tipoImagen_id"
                                data-placeholder="Seleccione Un Modelo" style="width: 100%;">


                                @if(sizeof($tipoImagenes)>0)
                                @foreach ($tipoImagenes as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach

                                @endif


                            </select>
                        </div>


                        <br />

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
                <form id="formDelete" method="POST">
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
        
       
        
        
        
        
        
        
        
        //la siguiente funcion recarga toda la tabla
        $('#reiniciar').click(function(){
            // $("#tipoMovimiento ").prop("selectedIndex", 0) ;
            
            $('#filtro_nombre').val('');
            $('#filtro_cantidad').val('');
            //cargar el select
            $('#filtro_modelo').find('option').remove();
            $('#filtro_modelo').append($('<option>', {
                value: vacio,
                text: 'Cualquiera',
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
            var filtro_cantidad = $('#filtro_cantidad').val().trim().toUpperCase();
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
                        (data[indiceModelos].toUpperCase().includes(filtro_modelo.toUpperCase()))? filtro_completos++ :0;
                        // (contieneModelo>-1)? filtro_completos++ : 0;
                        (filtro_cantidad<=data[indiceCantidad])? filtro_completos++ :0;
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
                            // (contieneModelo>-1)? filtro_completos++ : 0;
                            (data[indiceModelos].toUpperCase().includes(filtro_modelo.toUpperCase()))? filtro_completos++ :0;
                            
                            if(filtro_completos==cantidad_filtros){
                                return true;
                            }
                        }
                        if((filtro_cantidad.length>0)){
                            
                            (filtro_cantidad<=data[indiceCantidad])? filtro_completos++ :0;
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
                    $("#sample_form").attr("action","{{route('imagen.store')}}");
                    $('.modal-title').text("Agregar Nueva Imagen Al Sistema");
                    $('#action_button').val("Agregar");
                    $('#action').val("Add");
                    $('#nombre').val('');
                    $('#detalle').val('');
                    $('#precioUnitario').val('');
                    $('#cantidad').val('');
                    $('#modelos').find('option').attr('selected',false).ready();
                    // $('#imagenPrincipal').val('');
                    $('#hidden_id').val('');
                    
                    $('#formModal').modal('show');
                });
                
                
                
                //el boton edit en el index que mostrara el modal
                $(document).on('click', '.edit', function(){
                    var id = $(this).attr('id');
                    $("#sample_form").attr("action","{{route('imagen.update')}}");
                    $('#form_result').html('');
                    $.ajax({
                        url:"/imagen/"+id+"/edit",
                        contentType: false,
                        cache:false,
                        processData: false,
                        dataType:"json",
                        success:function(html){
                            console.log(html);
                            
                            //el data es la variable que contiene todo los atributos del objeto que se paso por la ruta
                            $('#nombre').val(html.data.nombre);
                           
                        
                            //*******************************Cargar el selected de Medidas SELECT SIMPLE********************************************
                            $('#tipoImagen_id').find('option').remove();
                            html.totalTipoImagenes.forEach(tipo => {
                                $('#tipoImagen_id').append($('<option>', {
                                    value: tipo.id,
                                    text: tipo.nombre,
                                }));
                            });
                            $('#tipoImagen_id option[value="'+html.tipoImagen.id+'"]').attr('selected','selected');
                            //*********************************Cargar imagen***********************************************************
                            
                            let preview = document.getElementById('preview'),
                            image = document.createElement('img');
                            image.src='{{asset("/imagenes/sublimaciones/")}}'+'/'+html.tipoImagen.nombre+'/'+html.data.imagen;
                            image.height='200';
                            image.width='200';
                            preview.innerHTML = '';
                            preview.append(image);
                            
                            
                            $('.modal-title').text("Editar Imagen");
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
                    var url= '{{route("imagen.destroy",':id')}}';
                    url= url.replace(':id',id);
                   
                    $('#formDelete').attr('action',url);
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