@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-left">

                <div class="card-header">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                    <h3>Filtro de Tipos de Imagenes</h3>
                </div>


                <div class="card-body">
                    <div class="row">

                        <div class="form-group col">
                            <label>Nombre : </label>
                            <input class="form-control" type="text" name="filtro_nombre" id="filtro_nombre"
                                data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
                        </div>



                    </div>
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
                    <h3>Lista de Tipo de Imagenes</h3>
                </div>
                <div class="card-body">

                    <div align="left">
                        <button type="button" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear Nuevo Tipo de Imagen</button>

                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>&nbsp; </th>

                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($tipoImagenes)>0)

                                @foreach ($tipoImagenes as $tipo)
                                <tr>

                                    <td align="right">{{$tipo->id}} </td>
                                    <td>{{$tipo->nombre}} </td>



                                    <td align="center">
                                        <button type="button" name="edit" id="{{$tipo->id}}"
                                            class="edit btn btn-outline-primary btn-sm">Editar</button>
                                        &nbsp;&nbsp;
                                        <button type="button" name="delete" id="{{$tipo->id}}"
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
@include('tipoImagen.modal')
@endsection