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

                    <div class="form-group row justify-content-center">
                        <label for="">Subir Imagen</label>
                        <hr>
                        <input type="file" name="imagenPrincipal" id="imagenPrincipal">
                        <div id="preview" class="row justify-content-center">
                            <img src="" alt="" height="200px" width="200px">
                        </div>
                    </div>
                    <div class="form-group clearfix col">
                        <label for="">Seleccionar como Predeterminado: </label>
                        <div class="icheck-success d-inline">
                            <input type="checkbox" checked id="seleccionado" name="seleccionado">
                            <label for="seleccionado" id='labelOperacion'>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label">Nombre: </label>
                        <input type="text" name="nombre" id="nombre" required placeholder="Ingrese un Nombre"
                            class="form-control" />
                    </div>
                    <div class="form-group row">
                        <label class="control-label">Email: </label>

                        <input id="email" type="email" class="form-control  @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Correo Electronico">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label class="control-label">Telefono Fijo: </label>
                        <input type="text" name="telefono" id="telefono" required
                            placeholder="Ingrese un numero telefono" class="form-control" />
                    </div>
                    <div class="form-group row">
                        <label class="control-label">WhatsApp: </label>
                        <input type="text" name="contacto" id="contacto" placeholder="Ingrese un numero de contacto"
                            class="form-control" />
                    </div>

                    {{--Direciones ************************************************--}}

                    <div class="form-group row ">
                        <div class="col">
                            <label class="control-label">Numero de Domicilio: </label>
                            <input type="text" class="form-control text-left" name="domicilio" id="domicilio" data-mask
                                data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">

                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label class="control-label">Calle: </label>
                            <div class="input-group mb-3 ">
                                <select class="select2" id='calle_id' name="calle_id"
                                    data-placeholder="Seleccione Una Calle" style="width: 100%;"
                                    aria-describedby="boton-agregar-calle">
                                    @if(sizeof($calles)>0)
                                    @foreach ($calles as $calle)
                                    <option value="{{$calle->id}}">{{$calle->nombre}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label class="control-label">Localidad: </label>
                            <div class="input-group mb-3 ">
                                <select class="select2" id='localidad_id' name="localidad_id"
                                    data-placeholder="Seleccione Una Localidad" style="width: 100%;"
                                    aria-describedby="boton-agregar-localidad">
                                    @if(sizeof($localidades)>0)
                                    @foreach ($localidades as $localidad)
                                    <option value="{{$localidad->id}}">{{$localidad->nombre}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label class="control-label">Provincia: </label>
                            <div class="input-group mb-3 ">
                                <select class="select2" id='provincia_id' name="provincia_id"
                                    data-placeholder="Seleccione Una Provincia" style="width: 100%;">
                                    @if(sizeof($provincias)>0)
                                    @foreach ($provincias as $provincia)
                                    <option value="{{$provincia->id}}">{{$provincia->nombre}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label class="control-label">Pais: </label>
                            <div class="input-group mb-3 ">
                                <select class="select2" id='pais_id' name="pais_id"
                                    data-placeholder="Seleccione Un Pais" style="width: 100%;">
                                    @if(sizeof($paises)>0)
                                    @foreach ($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                    @endforeach
                                    @endif
                                </select>


                            </div>

                        </div>

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
                <form id="formDelete" action="{{route('configuracion.destroy')}}" method="POST">
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
                // $("#pais ").prop("selectedIndex", 0) ;
                
                $('#filtro_nombre').val('');
    
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
                //se guardan la cantidad de filtros que se quieren realizar
                var cantidad_filtros=0;
                if((filtro_nombre!='')){
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
                        if(cantidad_filtros==1){
                           
                            (data[1].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
                            //si cummple con los tres filtro que guarde en la tabla la fila
                            return filtro_completos==cantidad_filtros? true:false;
                            
                        }else{
                            
                            if((filtro_nombre!='')){
                                (data[1].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
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
            
           
            
            //la siguiente funcion filtra toda la tabla
            $('#filtrar').click(function(){
                return filtro_funcion();
            }) ;
            
            
            //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
            $('#create_record').click(function(){
                $('#form_result').html('');
                $("#sample_form").attr("action","{{route('configuracion.store')}}");
                $('.modal-title').text("Agregar Nueva Configuracion");
                $('#action_button').val("Agregar");
                $('#action').val("Add");
                $('#formModal').modal('show');
                $('#nombre').val('');
                
                $('#hidden_id').val('');
            });
            
            
            //el boton edit en el index que mostrara el modal
            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $("#sample_form").attr("action","{{route('configuracion.update')}}");
                $('#form_result').html('');
                url2="{{route('configuracion.edit',":id")}}";                     
                url2=url2.replace(':id',id);
                $.ajax({
                    url:url2,
                    contentType: false,
                    cache:false,
                    processData: false,
                    dataType:"json",
                    success:function(html){
                        //el data es la variable que contiene todo los atributos del objeto que se paso por la ruta
                        console.log(html.data);
                        $('#nombre').val(html.data.nombre);
                        $('#email').val(html.data.email);
                        $('#telefono').val(html.data.telefono);
                        $('#contacto').val(html.data.contacto);
                        $('#domicilio').val(html.direccion.numero);
                        $('#imagenPrincipal').val('');
                        $('#preview').html('<img src="{{asset("/imagenes/configuraciones/")}}/'+html.data.imagenPrincipal+'" alt="" height="200px" width="200px">');
                        if(html.data.seleccionado){
                            document.getElementById("seleccionado").checked = true;
                        }else{
                            document.getElementById("seleccionado").checked = false;
                        }
                         
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Editar Configuracion");
                        $('#action_button').val("Editar");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            });
            
            
            
            $(document).on('click', '.delete', function(){
            var id;
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