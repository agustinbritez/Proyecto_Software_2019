@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col">
            {{-- <div class="card text-left">

                <div class="card-header">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                    <h3>Filtro de Propuestas Materia Primas</h3>
                </div>


                <div class="card-body">
                    <form action="{{route('pdf.materiaPrima')}}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div align="right">

                            <button type="submit" class="btn  btn-success  btn-flat btn-sm">Reporte Materia
                                Prima</button>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="form-group col">
                                <label>Nombre : </label>
                                <input class="form-control" type="text" name="filtro_nombre" id="filtro_nombre"
                                    data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
                            </div>
                            <div class="form-group col ">
                                <label class="control-label">Cantidad : </label>

                                <input type="text" class="form-control text-left" name="filtro_cantidad"
                                    id="filtro_cantidad" placeholder="Cantidad de materia prima" data-mask
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0,
									'digitsOptional': false, 'placeholder': '0'">

                            </div>
                            <div class="form-group col">
                                <label>Materia Prima : </label>
                                <select class="select2" name="filtro_materiaPrima" id="filtro_materiaPrima"
                                    data-placeholder="Seleccione Un Modelo" style="width: 100%;">
                                    <option value="-1">Cualquiera</option>
                                    @if(sizeof($materiaPrimas)>0)
                                    @foreach ($materiaPrimas as $materia)
                                    <option value="{{$materia->id}}">{{$materia->nombre}}</option>
                                    @endforeach

                                    @endif
                                </select>
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

            </div> --}}

            <div class="card text-left">


                <div class="card-header">
                    <h3>Lista de Propuestas</h3>
                </div>
                <div class="card-body">

                    <div align="left">
                        <form action="{{ route('materiaPrima.verificarStock') }}">
                            @csrf

                            <button type="submit" name="create_record" id="create_record"
                                class="btn btn-success btn-sm">Enviar Correo a los proveedores</button>
                        </form>
                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>Imagen </th>
                                    <th>Materia Prima</th>
                                    <th>Proveedor</th>
                                    <th>Precio Unitario</th>
                                    <th>Unidad Medida</th>
                                    <th>Detalle</th>
                                    <th>Fecha Actualizacion</th>
                                    {{-- <th>Imagen Principal</th> --}}
                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($propuestas)>0)

                                @foreach ($propuestas as $propuesta)
                                <tr>


                                    <td><img src="{{asset("/imagenes/materia_primas/".$propuesta->materiaPrima->imagenPrincipal)}}"
                                            alt="" width='70px' height='70px'></td>
                                    <td>{{$propuesta->materiaPrima->nombre}} </td>
                                    <td>
                                        {{$propuesta->proveedor->nombre .' ('.$propuesta->proveedor->email.')'}}
                                    </td>

                                    <td>
                                        <p for="" data-mask
                                            {{-- data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false"> --}}
                                            data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,
										'digitsOptional': false, 'placeholder': '0'">
                                            {{$propuesta->precioUnitario}}
                                        </p>
                                    </td>


                                    <td>
                                        @if ($propuesta->medida!=null)

                                        {{$propuesta->medida->nombre ?? 'Sin Medida'}}
                                        @else
                                        Sin Medida
                                        @endif

                                    </td>
                                    {{-- <td>Imagen Principal</td> --}}
                                    <td>
                                        <button type="button" class="btn btn-info  verDetalle"
                                            data-id="{{$propuesta->id}}">Ver detalle</button>

                                        <input type="hidden" id="detalle_{{$propuesta->id}}"
                                            value="{{$propuesta->detalle ?? 'Sin detalle'}}">

                                    </td>
                                    <td>{{$propuesta->updated_at->format('d/m/Y')}}</td>
                                    <td>
                                        <div class="row">
                                            <form action="{{ route('materiaPrima.propuesta', $propuesta->id) }}">

                                                <button type="submit" name="edit" id="{{$propuesta->id}}"
                                                    class="btn btn-outline-primary ">Ver Mas Informacion</button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>Imagen </th>
                                    <th>Materia Prima</th>
                                    <th>Proveedor</th>
                                    <th>Precio Unitario</th>
                                    <th>Unidad Medida</th>
                                    <th>Detalle</th>
                                    <th>Fecha Actualizacion</th>
                                    {{-- <th>Imagen Principal</th> --}}
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
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 align="center" style="margin:0;">Informacion Extra</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <textarea id="informacion" class="form-control" cols="50" rows="5" style="resize: none">

                </textarea>
            </div>
            <div class="modal-footer">

                {{-- Paso el id de la materia  aborrar en materia_delete--}}

                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
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
    $('[data-mask]').inputmask();
    $('.verDetalle').click(function(){
        var id = $(this).attr('data-id');
        console.log(id);
        // $('#informacion').text('');

        $('#informacion').text(document.getElementById("detalle_"+id).value);
        $('#confirmModal').modal('show');
    });
</script>
@endpush