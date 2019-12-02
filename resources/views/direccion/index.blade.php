@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col">
            <div class="card text-left">
                <div class="card-header">
                    <h3>Lista de Direcciones</h3>
                </div>
                <div class="card-body">

                    <div align="left">
                        <button type="button" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear
                            Nueva Direccion</button>

                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID</th>
                                    <th>Calle</th>
                                    <th>Numero</th>
                                    <th>Codigo Postal</th>
                                    <th>Localidad</th>
                                    <th>Provincia </th>
                                    <th>Pais </th>
                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($direcciones)>0)

                                @foreach ($direcciones as $direccion)
                                <tr>

                                    <th>{{$direccion->id}} </th>
                                    <th>{{$direccion->calle->nombre}}</th>
                                    <th>{{$direccion->numero}}</th>
                                    <th>{{$direccion->localidad->codigoPostal}}</th>
                                    <th>{{$direccion->localidad->nombre}}</th>
                                    <th>{{$direccion->provincia->nombre}}</th>
                                    <th>{{$direccion->pais->nombre}}</th>
                                    <th>
                                        <button type="button" name="edit" id="{{$direccion->id}}"
                                            class="edit btn btn-outline-primary btn-sm">Editar</button>
                                        &nbsp;&nbsp;
                                        <button type="button" name="delete" id="{{$direccion->id}}"
                                            class="delete btn btn-outline-danger btn-sm">Eliminar</button>
                                    </th>


                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                            <tfoot style="background-color:#ccc; color:white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Calle</th>
                                    <th>Numero</th>
                                    <th>Codigo Postal</th>
                                    <th>Localidad</th>
                                    <th>Provincia </th>
                                    <th>Pais </th>
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
@include('direccion.modal')
@endsection