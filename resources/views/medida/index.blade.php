@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col">
        <div class="card text-left">
            <div class="card-header">
                <h3>Lista de Medidas</h3>
            </div>
            <div class="card-body">

                <div align="left">
                    <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Crear
                        Nueva Medida</button>

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
                            @if (sizeof($medidas)>0)

                            @foreach ($medidas as $medida)
                            <tr>

                                <th>{{$medida->id}} </th>
                                <th>{{$medida->nombre}}</th>
                                <th>
                                    <button type="button" name="edit" id="{{$medida->id}}"
                                        class="edit btn btn-outline-primary btn-sm">Editar</button>
                                    &nbsp;&nbsp;
                                    <button type="button" name="delete" id="{{$medida->id}}"
                                        class="delete btn btn-outline-danger btn-sm">Eliminar</button>
                                </th>


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
@include('medida.modal')
@endsection