@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col">
            <div class="card text-left">

                <div class="card-header">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                    <h3>Filtro de Modelos</h3>
                </div>


                <div class="card-body">
                    <form action="{{route('pdf.modelo')}}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div align="right">

                            <button type="submit" class="btn  btn-success  btn-flat btn-sm">Reporte Modelos</button>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="form-group col">
                                <label>Nombre : </label>
                                <input class="form-control" type="text" name="filtro_nombre" id="filtro_nombre"
                                    data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
                            </div>
                            <div class="form-group col ">
                                <label class="control-label">Precio Unitario Minimo : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control text-left" id="filtro_precioUnitarioMin"
                                        name="filtro_precioUnitarioMin" data-mask
                                        data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false,  'placeholder': '0'">
                                </div>
                            </div>
                            <div class="form-group col ">
                                <label class="control-label">Precio Unitario Maximo : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control text-left" id="filtro_precioUnitarioMax"
                                        name="filtro_precioUnitarioMax" data-mask
                                        data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false,  'placeholder': '0'">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="card-footer text-muted">
                    <div class="text-center">
                        <button type="button" name="filtrar" id="filtrar"
                            class="btn btn-success btn-sm">Filtrar</button>
                        <button type="button" name="reiniciar" id="reiniciar" class="btn btn-info btn-sm">Reiniciar
                            Tabla</button>
                    </div>
                </div>

            </div>

            <div class="card text-left">


                <div class="card-header">
                    <h3>Lista de Modelos</h3>
                </div>
                <div class="card-body">

                    <div align="left">

                        <a href="{{route('modelo.create')}}" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear Nuevo Modelo</a>


                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Precio Unitario</th>
                                    <th>Receta</th>

                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($modelos)>0)

                                @foreach ($modelos as $modelo)
                                <tr>

                                    <td>{{$modelo->id}} </td>

                                    <td><img src="{{asset("/imagenes/modelos/".$modelo->imagenPrincipal)}}" alt=""
                                            width='70px' height='70px'></td>
                                    <td>{{$modelo->nombre??'Sin nombre'}} </td>
                                    <td>{{$modelo->precioUnitario??'Sin precio'}} </td>
                                    <td>
                                        @if (sizeof($modelo->recetaPadre)>0)

                                        @foreach ($modelo->recetaPadre as $receta)
                                        @if ($receta->modeloHijo!=null)
                                        <span class="badge badge-info"
                                            id="modelo_{{$receta->id}}">{{$receta->modeloHijo->nombre}}</span>&nbsp;&nbsp;

                                        @else

                                        <span class="badge badge-info"
                                            id="modelo_{{$receta->id}}">{{$receta->materiaPrima->nombre}}</span>&nbsp;&nbsp;
                                        @endif
                                        @endforeach
                                        @endif

                                    </td>


                                    <td>
                                        <div class="row">

                                            <a href="{{route('modelo.modificar',$modelo->id)}}" type="button"
                                                name="edit" id="{{$modelo->id}}"
                                                class="edit btn btn-outline-primary btn-sm">Editar</a>


                                            &nbsp;&nbsp;
                                            <form id="formDelete{{$modelo->id}}"
                                                action="{{route('modelo.destroy',$modelo->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" name="delete" id="{{$modelo->id}}"
                                                    class="delete btn btn-outline-danger btn-sm">Eliminar</button>
                                            </form>

                                        </div>

                                    </td>


                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Precio Unitario</th>
                                    <th>Receta</th>

                                    <th>&nbsp; </th>

                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    {{-- 2 days ago --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

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