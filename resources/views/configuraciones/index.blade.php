@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col-sm-12">

            <div class="card text-left">


                <div class="card-header">
                    <h3>Lista de Configuracion</h3>
                </div>
                <div class="card-body">

                    <div align="left">
                        <button type="button" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear Nueva Configuracion</button>

                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Contacto</th>
                                    <th>Email</th>
                                    <th>Direccion</th>
                                    <th>Seleccionado</th>
                                    <th>&nbsp; </th>

                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($configuraciones)>0)

                                @foreach ($configuraciones as $configuracion)
                                <tr>
                                    <td><img src="{{asset("/imagenes/configuraciones/".$configuracion->imagenPrincipal)}}"
                                            alt="" width='70px' height='70px'></td>
                                    <td>{{$configuracion->nombre}} </td>
                                    <td>{{$configuracion->telefono}} </td>
                                    <td>{{$configuracion->contacto}} </td>
                                    <td>{{$configuracion->email}} </td>
                                    <td>{{$configuracion->direccion->obtenerDireccion()}} </td>
                                    <td>
                                        @if ($configuracion->seleccionado)
                                        SI
                                        @else
                                        NO
                                        @endif

                                    </td>
                                    <td>
                                        <div class="row">
                                            <button type="button" name="edit" id="{{$configuracion->id}}"
                                                class="edit btn btn-outline-primary btn-sm">Editar</button>
                                            &nbsp;&nbsp;
                                            <button type="button" name="delete" id="{{$configuracion->id}}"
                                                class="delete btn btn-outline-danger btn-sm">Eliminar</button>
                                        </div>

                                    </td>


                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Contacto</th>
                                    <th>Email</th>
                                    <th>Direccion</th>
                                    <th>Seleccionado</th>
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
@include('configuraciones.modal')
@endsection