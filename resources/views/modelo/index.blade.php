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
                        
                            <a  href="{{route('modelo.create')}}"  name="create_record" id="create_record" class="btn btn-success btn-sm">Crear Nuevo Modelo</a>
                        

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
                                    <td>{{$modelo->nombre}} </td>
                                    <td>{{$modelo->precioUnitario}} </td>
                                    <td>
                                        @if (sizeof($modelo->recetaPadre)>0)

                                        @foreach ($modelo->recetaPadre as $receta)

                                        <span class="badge badge-info"
                                            id="modelo_{{$receta->id}}">{{$receta->modeloHijo->nombre}}</span>&nbsp;&nbsp;
                                        @endforeach
                                        @endif

                                    </td>


                                    <td>
                                        <button type="button" name="edit" id="{{$modelo->id}}"
                                            class="edit btn btn-outline-primary btn-sm">Editar</button>
                                        &nbsp;&nbsp;
                                        <button type="button" name="delete" id="{{$modelo->id}}"
                                            class="delete btn btn-outline-danger btn-sm">Eliminar</button>

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