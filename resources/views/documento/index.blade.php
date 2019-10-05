@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col">
        <div class="card text-left">
            <div class="card-header">
                <h3>Lista de Documentos</h3>
            </div>
            <div class="card-body">

                <div align="left">
                    <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Crear
                        Nuevo Documento</button>

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
                            @if (sizeof($documentos)>0)

                            @foreach ($documentos as $documento)
                            <tr>

                                <th>{{$documento->id}} </th>
                                <th>{{$documento->nombre}}</th>
                                <th>
                                    <button type="button" name="edit" id="{{$documento->id}}"
                                        class="edit btn btn-outline-primary btn-sm">Editar</button>
                                    &nbsp;&nbsp;
                                    <button type="button" name="delete" id="{{$documento->id}}"
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
@include('documento.modal')
@endsection