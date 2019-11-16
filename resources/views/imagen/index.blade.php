@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col-sm-12">


            <div class="card text-left">


                <div class="card-header">
                    <h3>Lista de Imagenes</h3>
                </div>
                <div class="card-body">

                    <div align="left">
                        <button type="button" name="create_record" id="create_record"
                            class="btn btn-success btn-sm">Crear Nueva Imagen</button>

                    </div>

                    <hr>
                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr>
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Tipo Imagen</th>
                                    <th>&nbsp; </th>


                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                @if (sizeof($imagenes)>0)

                                @foreach ($imagenes as $imagen)
                                <tr>

                                    <td>{{$imagen->id}} </td>

                                    <td><img src="{{asset("/imagenes/sublimaciones/".$imagen->tipoImagen->nombre.'/'.$imagen->imagen)}}"
                                            alt="" width='70px' height='70px'></td>
                                    <td>{{$imagen->nombre??'Sin nombre'}} </td>
                                    <td>{{$imagen->tipoImagen->nombre ?? 'Sin tipo de imagen'}}</td>


                                    <td>
                                        <div class="row">

                                            <button type="button" name="edit" id="{{$imagen->id}}"
                                                class="edit btn btn-outline-primary btn-sm">Editar</button>

                                            &nbsp;&nbsp;
                                            <button type="button" name="delete" id="{{$imagen->id}}"
                                                class="delete btn btn-outline-danger btn-sm">Eliminar</button>

                                    </td>

                    </div>

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
                            <th>Tipo Imagen</th>
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

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
							$('.select2').select2(
							// {theme: 'bootstrap4'}
							);
						});
</script>
@endpush

@section('htmlFinal')
@include('imagen.modal')
@endsection