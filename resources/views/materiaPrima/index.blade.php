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
					<h3>Filtro de Materia Primas</h3>
				</div>


				<div class="card-body">
					<form action="{{route('pdf.materiaPrima')}}" method="GET" enctype="multipart/form-data">
					{{-- <form action=""> --}}
						@csrf
						<div align="right">

							<button type="submit" class="btn  btn-success  btn-flat btn-sm">Reporte Materia
								Prima</button>
						</div>
						<hr>
						<div class="row">

							<div class="form-group col">
								<label>Nombre : </label>
								<input class="form-control" type="text" name="filtro_nombre" id="filtro_nombre"
									data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
							</div>
							<div class="form-group col ">
								<label class="control-label">Cantidad Minima : </label>

								<input type="text" class="form-control text-left" name="filtro_cantidad"
									id="filtro_cantidad" placeholder="Cantidad de materia prima" data-mask
									data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0,
									'digitsOptional': false, 'placeholder': '0'">

							</div>

							<div class="form-group col clearfix">

								<label>
									Stock Minimo:
								</label>
								<select class="select2" name="filtro_minimo" id="filtro_minimo"
									data-placeholder="Seleccione " style="width: 100%;">
									<option value="-1">Cualquiera</option>
									<option value="0">Si</option>
									<option value="1">No</option>
								</select>

							</div>
							<div class="form-group col">
								<label>Opciones de Productos : </label>
								<select class="select2" name="filtro_modelo" id="filtro_modelo"
									data-placeholder="Seleccione Un Modelo" style="width: 100%;">
									{{-- <option value="" selected>Cualquiera</option> --}}
									<option value="-1">Cualquiera</option>
									@if(sizeof($modelos)>0)
									@foreach ($modelos as $modelo)
									<option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
									@endforeach

									@endif
								</select>
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
					<h3>Lista de Materia Primas</h3>
				</div>
				<div class="card-body">

					<div align="left">
						@if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin'))


						<button type="button" name="create_record" id="create_record"
							class="btn btn-success btn-sm">Crear Nueva Materia Prima</button>
						@endif

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
									<th>Cantidad</th>
									<th>Stock Minimo</th>
									<th>Medida </th>
									<th>Opciones de Productos </th>
									{{-- <th>Imagen Principal</th> --}}
									<th>&nbsp; </th>


								</tr>
							</thead>
							<tbody style="background-color:white ; color:black;">
								@if (sizeof($materiaPrimas)>0)

								@foreach ($materiaPrimas as $materia)
								<tr>

									<td>{{$materia->id}} </td>

									<td><img src="{{asset("/imagenes/materia_primas/".$materia->imagenPrincipal)}}"
											alt="" width='70px' height='70px'></td>
									<td>{{$materia->nombre}} </td>
									<td class="text-right">{{number_format($materia->precioUnitario,2)}} </td>
									<td class="text-right">

										{{number_format($materia->cantidad) }}

									</td>
									<td class="text-right">

										{{number_format($materia->stockMinimo) }}

									</td>
									@if ($materia->medida!=null)
									<td>{{$materia->medida->nombre}} </td>

									@else

									<td>Sin medida </td>

									@endif
									<td>
										@if (sizeof($materia->modelos)>0)

										@foreach ($materia->modelos as $modelo)

										<span class="badge badge-info"
											id="modelo_{{$modelo->id}}">{{$modelo->nombre}}</span>&nbsp;&nbsp;
										@endforeach
										@endif

									</td>
									{{-- <td>Imagen Principal</td> --}}
									<th>
										@if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin'))


										<button type="button" name="edit" id="{{$materia->id}}"
											class="edit btn btn-outline-primary btn-sm">Editar</button>
										&nbsp;&nbsp;
										<button type="button" name="delete" id="{{$materia->id}}"
											class="delete btn btn-outline-danger btn-sm">Eliminar</button>

										@endif
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
									<th>Cantidad</th>
									<th>Stock Minimo</th>

									<th>Medida </th>
									<th>Opciones de Productos </th>
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
@include('materiaPrima.modal')
@endsection