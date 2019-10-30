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
                    <h3>Filtro de Auditoria </h3>
                </div>

                <div class="card-body">
                    <form action="{{route('pdf.materiaPrima')}}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div align="right">

                            <button type="submit" class="btn  btn-success  btn-flat btn-sm">Reporte Auditoria</button>
                        </div>
                        <hr>
                        <div class="row">


                            <div class="form-group col">
                                <label>Tabla : </label>
                                <select class="select2" name="filtro_tabla" id="filtro_tabla"
                                    data-placeholder="Seleccione Una Tabla" style="width: 100%;">
                                    <option value="-1" selected>Cualquiera</option>
                                    <option value="Movimiento">Movimiento</option>
                                    <option value="Modelo">Modelo</option>
                                    <option value="MateriaPrima">MateriaPrima</option>
                                    <option value="TipoMovimiento">TipoMovimiento</option>
                                </select>
                            </div>
                            <div class="form-group col">
                                <label>Desde</label>
                                <input type="date" id="min" name="desde" value="" class="form-control">
                            </div>

                            <div class="form-group col">
                                <label>Hasta</label>
                                <input type="date" id="max" name="hasta" value="" class="form-control">
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
                    <h3>Lista de Auditoria</h3>
                </div>
                <div class="card-body">

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover' id='data-table'>
                            {{-- <thead style="background-color:white ; color:black;"> --}}
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID Objeto</th>
                                    <th>Tabla</th>
                                    <th>Usuario</th>
                                    <th>Operacion</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @foreach ($auditorias as $auditoria)
                                <tr>
                                    <td>{{$auditoria->auditable_id}}</td>
                                    <td>{{ str_replace(['App\\', '$', ' '], '', $auditoria->auditable_type)}}</td>
                                    <td>{{$auditoria->user->name .' '.$auditoria->user->apellido  }}</td>
                                    <td>{{$auditoria->event }}</td>
                                    <td>{{$auditoria->created_at->format('d/m/Y') }}</td>
                                    <td>{{$auditoria->created_at->format('H:m:s') }}</td>
                                    <td>
                                        <form action="{{route('auditoria.show',$auditoria->id)}}">
                                            <button type="submit" name="show" id="{{$auditoria->id}}"
                                                class=" btn btn-outline-info btn-sm">Ver Detalles</button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach


                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>ID Objeto</th>
                                    <th>Tabla</th>
                                    <th>Usuario</th>
                                    <th>Operacion</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
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



@section('htmlFinal')

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
                    
                    // parseFloat('21')<parseFloat('1000')?alert('verddero'+parseFloat('1000')):alert('false'+parseFloat('1000'));
                    //variables globales 
                    //indices del data table que uso para el filtro
                    var indiceNombre=2;
                    var indiceFecha=4;
                    var indiceTabla=1;
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
                        // processing: true,
                        // serverSide: true,
                        // ajax:{
                            //     url: "{{ route('auditoria.index') }}",
                            // },
                            // columns:[
                            // {
                                //     data: 'auditable_id',
                                //     name: 'auditable_id',
                                // },
                                // {
                                    //     data: 'tabla',
                                    //     name: 'tabla'
                                    // },
                                    // {
                                        //     data: 'usuario',
                                        //     name: 'usuario'
                                        // },
                                        // {
                                            //     data: 'event',
                                            //     name: 'event'
                                            // },
                                            // {
                                                //     data: 'fecha',
                                                //     name: 'fecha'
                                                // },
                                                // {
                                                    //     data: 'action',
                                                    //     name: 'action',
                                                    //     orderable: false
                                                    // }
                                                    // ]
                                                });
                                                
                                                //****************************************** FILTRO DE LA TABLA**************************************************************
                                                function filtro_funcion(){
                                                    
                                                    // var filtro_nombre = $('#filtro_nombre').val().trim().toUpperCase() ;
                                                    // var filtro_cantidad = $('#filtro_cantidad').val();
                                                     var filtro_tabla = $('#filtro_tabla option:selected').text();
                                                    var filtro_desde = $('#min').val();
                                                    var filtro_hasta = $('#max').val();

                                                    //se guardan la cantidad de filtros que se quieren realizar
                                                    var cantidad_filtros=0;
                                                    // if((filtro_nombre!='')){
                                                        //     cantidad_filtros++;
                                                        // }
                                                        if(filtro_tabla!=vacio){
                                                            cantidad_filtros++;
                                                        }
                                                        if((filtro_desde !='') && (filtro_hasta!='') ){
                                                            cantidad_filtros++;
                                                        }
                                                        
                                                        // if(filtro_cantidad.length>0){
                                                            //     cantidad_filtros++;
                                                            // }
                                                            
                                                            // console.log($('#filtro_tabla').text());
                                                            
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
                                                                    if(cantidad_filtros==2){
                                                                        //filtro de fechas
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
                                                                        //si contieneTabla es -1 no encontro en la cadena 
                                                                        (data[indiceTabla] == filtro_tabla)? filtro_completos++ :0;
                                                                        // (filtro_cantidad==data[indiceCantidad])? filtro_completos++ :0;
                                                                        // (data[indiceNombre].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
                                                                        //si cummple con los tres filtro que guarde en la tabla la fila
                                                                        return filtro_completos==cantidad_filtros? true:false;
                                                                        
                                                                    }else{
                                                                        
                                                                        //filtro fechas **********************************************************************************************
                                                                        var min = moment(filtro_desde);

                                                                        var max = moment(filtro_hasta) ;
                                                                        var d = data[indiceFecha];
                                                                        
                                                                        var datearray = d.split("/");
                                                                        var newdate =   datearray[2] + '/'+ datearray[1] + '/' + datearray[0] ;
                                                                        
                                                                        var s = new Date(newdate);
                                                                        var startDate = moment(s);
                                                                        // console.log(startDate);
                                                                        //comparamos el filtro entre la fechas
                                                                        if((filtro_desde !='') && (filtro_hasta!='') ){
                                                                            (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) )? filtro_completos++ : 0 ;
                                                                            
                                                                        }
                                                                        // si hay 1 o 2 filtros que compruebe todo
                                                                        
                                                                        //en data data[iFndiceNombre] la columna 1 que es Nombre en data[0] esta la columna ID
                                                                        //se coloco un if mas dentro de cada uno para optimizar
                                                                        if((filtro_tabla!=vacio)){
                                                                            //si contieneTabla es -1 no encontro en la cadena 
                                                                            (data[indiceTabla] == filtro_tabla)? filtro_completos++ :0;
                                                                            if(filtro_completos==cantidad_filtros){
                                                                                return true;
                                                                            }
                                                                        }
                                                                        return filtro_completos==cantidad_filtros? true:false;

                                                                        // if((filtro_cantidad.length>0)){
                                                                            
                                                                            //     (filtro_cantidad==data[indiceCantidad])? filtro_completos++ :0;
                                                                            //     if(filtro_completos==cantidad_filtros){
                                                                                //         return true;
                                                                                //     }
                                                                                // }
                                                                                // if((filtro_nombre!='')){
                                                                                    //     (data[indiceNombre].toUpperCase().includes(filtro_nombre))? filtro_completos++ :0;
                                                                                    //     if(filtro_completos==cantidad_filtros){
                                                                                        //         return true;
                                                                                        //     }
                                                                                        // }
                                                                                        //retorna saca de la tabla porque no cumple con ningun filtro 
                                                                                        
                                                                                    }
                                                                                    
                                                                                }
                                                                                $.fn.dataTable.ext.search.push( filtradoTabla );
                                                                            }
                                                                            table.draw();
                                                                        };
                                                                        
                                                                        $('#filtrar').click(function(){
                                                                            filtro_funcion();
                                                                        });
                                                                        
                                                                        
                                                                        
                                                                    });
</script>
@endpush