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
                    <h3>Flujo de trabajo</h3>
                </div>


                <div class="card-body">
                    <form action="{{route('pdf.materiaPrima')}}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div align="right">

                            <button type="submit" class="btn  btn-success  btn-flat btn-sm">Reporte de FLujos de
                                Trabajos</button>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="form-group col">
                                <label>Nombre : </label>
                                <input class="form-control" type="text" name="filtro_nombre" id="filtro_nombre"
                                    data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
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
                    <h3>Lista de Flujos de Trabajos</h3>
                </div>
                <div class="card-body">

                    <div align="left">
                        <button type="button" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear Nuevo Flujo de Trabajo</button>

                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Flujo de Trabajo</th>
                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($flujosTrabajos)>0)

                                @foreach ($flujosTrabajos as $flujo)
                                <tr>

                                    <td>{{$flujo->id}} </td>


                                    <td>{{$flujo->nombre}} </td>
                                    <td>

                                        @if ($flujo->getEstadoInicial()!=null)

                                        <span class="badge badge-success "
                                            id="estado_">{{$flujo->getEstadoInicial()->nombre}}
                                        </span><span><i class="fas fa-arrow-right"></i></span>

                                        @foreach ($flujo->getEstados() as $estado)
                                        @if ($estado!=null)

                                        @if (($estado->id!=$flujo->getEstadoInicial()->id)&&($estado->id!=
                                        $flujo->getEstadoFinal()->id))

                                        <span class="badge badge-info " id="estado_">{{$estado->nombre}} </span>
                                        <span><i class="fas fa-arrow-right"></i></span>

                                        @endif
                                        @endif
                                        @endforeach

                                        @if ($flujo->getEstadoFinal()->id != $flujo->getEstadoInicial()->id)
                                        <span class="badge badge-danger "
                                            id="estado_">{{$flujo->getEstadoFinal()->nombre}}
                                        </span>

                                        @endif

                                        @endif

                                    </td>


                                    <td>
                                        <button type="button" name="edit" id="{{$flujo->id}}"
                                            class="edit btn btn-outline-primary btn-sm">Editar</button>
                                        &nbsp;&nbsp;
                                        <button type="button" name="delete" id="{{$flujo->id}}"
                                            class="delete btn btn-outline-danger btn-sm">Eliminar</button>

                                    </td>


                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>ID</th>

                                    <th>Nombre</th>
                                    <th>Flujo de Trabajo</th>

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
@include('flujoTrabajo.modal')
@endsection