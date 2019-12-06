@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col-sm-12">
            {{-- <div class="card text-left">

                <div class="card-header">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                    <h3>Filtro de Usuarios</h3>
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
            </div> --}}

            <div class="card text-left">


                <div class="card-header">
                    <h3>Lista de Usuarios</h3>
                </div>
                <div class="card-body">

                    <div align="left">
                        <button type="button" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear Nuevo Usuario</button>

                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Documento</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>&nbsp; </th>

                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($usuarios)>0)

                                @foreach ($usuarios as $usuario)
                                <tr>

                                    <td>{{$usuario->name}} </td>
                                    <td>{{$usuario->apellido}} </td>
                                    <td>{{$usuario->getDocumento()}} </td>
                                    <td>{{$usuario->email}} </td>
                                    <td>
                                        @if (!$usuario->roles->isEmpty())
                                        @foreach ($usuario->roles as $rol)
                                        <div class="form-group">
                                            <span class="badge badge-info"
                                                id="modelo_{{$rol->id}}">{{$rol->name}}</span>
                                        </div>
                                        @endforeach

                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->hasRole('empleado'))
                                        @if (!$usuario->hasRole('empleado'))
                                        <button type="button" name="edit" id="{{$usuario->id}}"
                                            class="edit btn btn-outline-primary btn-sm">Editar</button>
                                        &nbsp;&nbsp;
                                        <button type="button" name="delete" id="{{$usuario->id}}"
                                            class="delete btn btn-outline-danger btn-sm">Eliminar</button>

                                        @endif

                                        @else
                                        <button type="button" name="edit" id="{{$usuario->id}}"
                                            class="edit btn btn-outline-primary btn-sm">Editar</button>
                                        &nbsp;&nbsp;
                                        <button type="button" name="delete" id="{{$usuario->id}}"
                                            class="delete btn btn-outline-danger btn-sm">Eliminar</button>
                                        @endif


                                    </td>


                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Documento</th>
                                    <th>Email</th>
                                    <th>Rol</th>
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

@endpush

@section('htmlFinal')
@include('usuarios.modal')
@endsection