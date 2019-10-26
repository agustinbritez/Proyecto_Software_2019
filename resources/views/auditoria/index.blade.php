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
                                <input class="form-control" type="text" name="filtro_nombre" id="filtro_nombre"
                                    data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
                            </div>
                            <div class="form-group col">
                                <label>Cantidad : </label>
                                <input class="form-control" type="number" name="filtro_cantidad" id="filtro_cantidad"
                                    style="width: 100%;">
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
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID</th>
                                    <th>Tabla</th>
                                    <th>Usuario</th>
                                    <th>Operacion</th>
                                    <th>Fecha</th>
                                    {{-- <th>Imagen Principal</th> --}}
                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @foreach ($auditorias as $auditoria)
                                <tr>
                                    <td>{{$auditoria->auditable_id}}</td>
                                    <td>{{$auditoria->auditable_type}}</td>
                                    {{-- <td>{{$auditoria->auditable_type}}</td> --}}
                                    <td>{{$auditoria->user->nombre .' '.$auditoria->user->apellido  }}</td>
                                    <td>{{$auditoria->event }}</td>
                                    <td>{{$auditoria->created_at->format('d/m/Y') }}</td>
                                    {{-- <td>Imagen Principal</td> --}}
                                    <td>&nbsp; </td>
                                </tr>
                                @endforeach


                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Tabla</th>
                                    <th>Operacion</th>
                                    <th>Fecha</th>
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

@endsection