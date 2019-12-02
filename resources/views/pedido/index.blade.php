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
                    <h3>Filtro de Pedidos</h3>
                </div>


                <div class="card-body">
                    <form action="{{route('pdf.pedido')}}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div align="right">

                            <button type="submit" class="btn  btn-success  btn-flat btn-sm">Reporte Pedidos</button>
                        </div>
                        <hr>
                        <div class="row">




                            <div class="form-group col text-center">
                                <label class="">Cantidad Productos : </label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control text-left" name="cantidadMin"
                                            id="cantidadMin" placeholder=" Minima" data-mask
                                            data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control text-left" name="cantidadMax"
                                            id="cantidadMax" placeholder=" Maxima" data-mask
                                            data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col ">
                                <label class="control-label " style="font-size:15px ">Precio Unitario Minimo - Maximo:
                                </label>
                                <div class="row">
                                    <div class="col">

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control text-left"
                                                id="filtro_precioUnitarioMin" name="filtro_precioUnitarioMin" data-mask
                                                data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false,  'placeholder': '0.00'">
                                        </div>
                                    </div>
                                    <div class="col">

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control text-left"
                                                id="filtro_precioUnitarioMax" name="filtro_precioUnitarioMax" data-mask
                                                data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false,  'placeholder': '0.00'">
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group col">
                                <label>Terminado : </label>
                                <select class="select2" name="filtro_terminado" id="filtro_terminado"
                                    data-placeholder="Seleccione Una Tabla" style="width: 100%;">
                                    <option value="-1">Cualquiera</option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="form-group col">
                                <label>Estado : </label>
                                <select class="select2" name="filtro_estado" id="filtro_estado"
                                    data-placeholder="Seleccione Un Estado" style="width: 100%;">
                                    {{-- <option value="" selected>Cualquiera</option> --}}
                                    <option value="-1">Cualquiera</option>
                                    @if(sizeof($estados)>0)
                                    @foreach ($estados as $estado)
                                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endforeach

                                    @endif
                                </select>
                            </div>



                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Fecha Pago Desde</label>
                                <input type="date" id="fechaPagoDesde" name="fechaPagoDesde" value=""
                                    class="form-control">
                            </div>

                            <div class="form-group col">
                                <label>Fecha Pago Hasta</label>
                                <input type="date" id="fechaPagoHasta" name="fechaPagoHasta" value=""
                                    class="form-control">
                            </div>
                            <div class="form-group col">
                                <label>Fecha Acualizacion Desde</label>
                                <input type="date" id="estadoDesde" name="estadoDesde" value="" class="form-control">
                            </div>

                            <div class="form-group col">
                                <label>Fecha Acualizacion Hasta</label>
                                <input type="date" id="estadoHasta" name="estadoHasta" value="" class="form-control">
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
                    <h3>Lista de Pedidos</h3>
                </div>
                <div class="card-body">

                    <div align="left">
                        @if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin'))

                        <button type="button" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear Nuevo Pedido </button>

                        @endif

                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID</th>
                                    <th>Cantidad de Productos</th>
                                    <th>Precio Total</th>
                                    <th>Fecha de Pago</th>
                                    <th>Estado</th>
                                    <th>Fecha de Cambio de Estado</th>
                                    <th>Terminado</th>
                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($pedidos)>0)

                                @foreach ($pedidos as $pedido)
                                <input type="hidden" name="" id="{{$cantidadProductos=0}}">
                                <tr>
                                    <td>{{$pedido->id}} </td>
                                    <td align="right">
                                        {{number_format($pedido->getCantidadProductos())}}


                                    </td>
                                    <td align="right">{{number_format($pedido->precio,2) ?? 0}} </td>
                                    @if ($pedido->fechaPago!=null)
                                    <td>{{$pedido->getFechaPago() ?? 'No pagado' }} </td>

                                    @else

                                    <td>{{ 'No pagado' }} </td>
                                    @endif
                                    <td>
                                        @if ($pedido->estado!=null)

                                        @if (($pedido->flujoTrabajo->getEstadoInicial()!=null)
                                        &&($pedido->flujoTrabajo->getEstadoFinal()!=null) )

                                        @if ($pedido->estado->id == $pedido->flujoTrabajo->getEstadoInicial()->id)
                                        <span
                                            class="badge badge-success">{{$pedido->estado->nombre ?? 'Sin Estado'}}</span>
                                        @else

                                        @if ($pedido->estado->id == $pedido->flujoTrabajo->getEstadoFinal()->id)
                                        <span
                                            class="badge badge-danger">{{$pedido->estado->nombre ?? 'Sin Estado'}}</span>
                                        @else
                                        <span
                                            class="badge badge-info">{{$pedido->estado->nombre ?? 'Sin Estado'}}</span>
                                        @endif
                                        @endif

                                        @else

                                        <span class="badge badge-info">{{'Sin Estado'}}</span>
                                        @endif

                                        @else
                                        <span class="badge badge-info">{{'Sin Estado'}}</span>
                                        @endif


                                    </td>

                                    @if ($pedido->cambioEstado!=null)

                                    <td>{{$pedido->getCambioEstado()?? 'No pagado' }} </td>
                                    @else

                                    <td>{{'No pagado' }} </td>
                                    @endif
                                    <td>

                                        @if ($pedido->terminado)
                                        Si
                                        @else
                                        No
                                        @endif


                                    </td>


                                    <th>
                                        <form action="{{route('detallePedido.index',$pedido->id)}}" method="GET">

                                            <button type="submit" name="edit" id="{{$pedido->id}}"
                                                class="btn btn-outline-primary btn-sm">Ver Detalles</button>
                                        </form>
                                        {{-- &nbsp;&nbsp;
                                                    <button type="button" name="delete" id="{{$pedido->id}}"
                                        class="delete btn btn-outline-danger btn-sm">Eliminar</button> --}}
                                        </td>


                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Cantidad de Productos</th>
                                    <th>Precio Total</th>
                                    <th>Fecha de Pago</th>
                                    <th>Estado</th>
                                    <th>Fecha de Cambio de Estado</th>
                                    <th>Terminado</th>
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
{{-- @include('pedido.modalIndex') --}}
@endsection


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
                    
                    var indiceCantidad=1;
                    var indicePrecio=2;
                    var indiceFechaPago=3;
                    var indiceEstado=4;
                    var indiceFechaCambio=5;
                    var indiceTerminado=6;
                    
                    var medidasGlobal;
                    var modelosGlobal;
                    const vacio='Cualquiera';
                    
                    
                    
                    //****************************************** FILTRO DE LA TABLA**************************************************************
                    function filtro_funcion(){
                        
                        var cantidadMin=parseInt($('#cantidadMin').val());
                        var cantidadMax=parseInt($('#cantidadMax').val());
                        var filtro_precioUnitarioMin=parseFloat($('#filtro_precioUnitarioMin').val());
                        var filtro_precioUnitarioMax=parseFloat($('#filtro_precioUnitarioMax').val());
                                                
                        var filtro_terminado=($('#filtro_terminado option:selected').text());
                        var filtro_estado=($('#filtro_estado option:selected').text());
                        var fechaPagoDesde=$('#fechaPagoDesde').val();
                        var fechaPagoHasta=$('#fechaPagoHasta').val();
                        var estadoDesde=$('#estadoDesde').val();
                        var estadoHasta=$('#estadoHasta').val();
                        
                        var cantidad_filtros=0;
                        
                        if((cantidadMin>0) && (cantidadMax>0)){
                            cantidad_filtros++;   
                            
                        }else if(cantidadMin>0){
                            cantidad_filtros++;   
                            
                        }else if(cantidadMax>0){
                            cantidad_filtros++;      
                        }
                        //
                        if((filtro_precioUnitarioMin>0.0) && (filtro_precioUnitarioMax>0.0)){
                            cantidad_filtros++;   
                            
                        }else if(filtro_precioUnitarioMin>0.0){
                            cantidad_filtros++;   
                            
                        }else if(filtro_precioUnitarioMax>0.0){
                            cantidad_filtros++;      
                        }
                        
                        
                        if(filtro_terminado!= 'Cualquiera'){
                            cantidad_filtros++;      
                        }
                        
                        if(filtro_estado!=vacio){
                            cantidad_filtros++;      
                        }
                        
                        //
                        if((fechaPagoDesde !='') && (fechaPagoHasta!='') ){
                            cantidad_filtros++;
                        }else if ((fechaPagoDesde !='')){
                            cantidad_filtros++;
                        }else if ((fechaPagoHasta !='')){
                            cantidad_filtros++;
                        }
                        //
                        if((estadoDesde !='') && (estadoHasta!='') ){
                            cantidad_filtros++;
                        }else if ((estadoDesde !='')){
                            cantidad_filtros++;
                        }else if ((estadoHasta !='')){
                            cantidad_filtros++;
                        }
                        console.log(cantidad_filtros);
                        
                        
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
                                //calculamos la fecha para el pago
                                var minPago = moment(fechaPagoDesde);
                                
                                var maxPago = moment(fechaPagoHasta) ;
                                var d1 = data[indiceFechaPago];
                                var datearray1 = d1.split("/");
                                var newdate1 =   datearray1[2] + '/'+ datearray1[1] + '/' + datearray1[0] ;
                                var s1 = new Date(newdate1)
                                var startDatePago = moment(s1)
                                //fecha para cambio de estado
                                var minEstado = moment(estadoDesde);
                                
                                var maxEstado = moment(estadoHasta) ;
                                var d1 = data[indiceFechaCambio];
                                var datearray1 = d1.split("/");
                                var newdate1 =   datearray1[2] + '/'+ datearray1[1] + '/' + datearray1[0] ;
                                var s1 = new Date(newdate1)
                                var startDateEstado = moment(s1)
                                
                              
                                    //filtro de fechas
                                    //*******************************************************
                                    if((fechaPagoDesde !='') && (fechaPagoHasta!='') ){
                                        
                                        (moment(startDatePago).isSameOrAfter(minPago) && moment(startDatePago).isSameOrBefore(maxPago) )? filtro_completos++ : 0 ;
                                        
                                    }else if((fechaPagoDesde !='')){
                                        // console.log(1);
                                        (moment(startDatePago).isSameOrAfter(minPago)  )? filtro_completos++ : 0 ;
                                        
                                    }else if((fechaPagoHasta !='')){
                                        
                                        (moment(startDatePago).isSameOrBefore(maxPago)  )? filtro_completos++ : 0 ;
                                    }
                                    //********************************************
                                    if((estadoDesde !='') && (estadoHasta!='') ){
                                        
                                        (moment(startDateEstado).isSameOrAfter(minEstado) && moment(startDateEstado).isSameOrBefore(maxEstado) )? filtro_completos++ : 0 ;
                                        
                                    }else if((estadoDesde !='')){
                                        // console.log(2);
                                        (moment(startDateEstado).isSameOrAfter(minEstado)  )? filtro_completos++ : 0 ;
                                        
                                    }else if((estadoHasta !='')){
                                        
                                        (moment(startDateEstado).isSameOrBefore(maxEstado)  )? filtro_completos++ : 0 ;
                                    }
                                    //************************************************************
                                    if(cantidadMin>0 && cantidadMax>0){
                                        ((parseInt(data[indiceCantidad])>= cantidadMin) && (parseInt(data[indiceCantidad])<= cantidadMax) )? filtro_completos++ :0;
                                        
                                        
                                    }else if(cantidadMin>0){
                                        // console.log(3);
                                        ((parseInt(data[indiceCantidad])>= cantidadMin))? filtro_completos++ :0;
                                        
                                    }else if(cantidadMax>0){
                                        ((parseInt(data[indiceCantidad])<= cantidadMax) )? filtro_completos++ :0;
                                    }
                                    //************************************************************
                                    if((filtro_precioUnitarioMin>0.0) && (filtro_precioUnitarioMax>0.0)){

                                        ((parseFloat(data[indicePrecio])>= filtro_precioUnitarioMin) && (parseFloat(data[indicePrecio])<= filtro_precioUnitarioMax) )? filtro_completos++ :0.0;
                                        
                                        
                                    }else if(filtro_precioUnitarioMin>0.0){
                                        // console.log(4);
                                        ((parseFloat(data[indicePrecio])>= filtro_precioUnitarioMin))? filtro_completos++ :0.0;
                                        
                                    }else if(filtro_precioUnitarioMax>0.0){
                                        ((parseFloat(data[indicePrecio])<= filtro_precioUnitarioMax) )? filtro_completos++ :0.0;
                                    }
                                    //***************************************************************8
                                    
                                    (data[indiceTerminado] == filtro_terminado)? filtro_completos++ :0;
                                    (data[indiceEstado] == filtro_estado)? filtro_completos++ :0;
                                    
                                    console.log('filtro_completos: '+filtro_completos+' cantidad_filtros: '+cantidad_filtros);
                                    return filtro_completos==cantidad_filtros? true:false;
                                    
                                
                                
                            }
                            $.fn.dataTable.ext.search.push( filtradoTabla );
                        }
                        table.draw();
                    };
                    $('#filtrar').click(function(){
                        filtro_funcion();
                    });
                    
                    
                    
                    $('#reiniciar').click(function(){
                        
                        $('#filtro_tabla').val('');
                        $('#filtro_user').val('');
                        $('#filtro_desde').val('');
                        $('#filtro_hasta').val('');
                        //cargar el select
                        
                        
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
</script>

@endpush