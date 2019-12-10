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
					<h3>Filtro de Tipos de Movimientos</h3>
				</div>


				<div class="card-body">
					<div class="row">

						<div class="form-group col">
							<label>Nombre : </label>
							<input class="form-control" type="text" name="filtro_nombre" id="filtro_nombre"
								data-placeholder="Ingrese un nombre a filtrar" style="width: 100%;">
						</div>

						<div class="form-group col clearfix">

							<label>
								Operacion:
							</label>
							<select class="select2" name="filtro_operacion" id="filtro_operacion"
								data-placeholder="Seleccione Un Modelo" style="width: 100%;">
								<option value="0">Sumar</option>
								<option value="1">Restar</option>
							</select>

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
					<h3>Lista de Tipo de Movimientos</h3>
				</div>
				<div class="card-body">

					<div align="left">
						<button type="button" name="create_record" id="create_record"
							class="btn btn-success btn-sm">Crear Nuevo Tipo Movimiento</button>

					</div>

					<hr>
					<div class="table-responsive ">
						<table class='table table-bordered table-striped table-hover datatable' id='data-table'>
							<thead style="background-color:white ; color:black;">
								<tr>
									<th>ID</th>
									<th>Nombre</th>
									<th>Operacion</th>
									<th>&nbsp; </th>

								</tr>
							</thead>
							<tbody style="background-color:white ; color:black;">
								@if (sizeof($tipoMovimientos)>0)

								@foreach ($tipoMovimientos as $movi)
								<tr>

									<th>{{$movi->id}} </th>
									<th>{{$movi->nombre}} </th>

									@if ($movi->operacion!=0)
									<th>Sumar</th>
									@else
									<th>Restar</th>
									@endif

									<th>
										<button type="button" name="edit" id="{{$movi->id}}"
											class="edit btn btn-outline-primary btn-sm">Editar</button>
										&nbsp;&nbsp;
										<button type="button" name="delete" id="{{$movi->id}}"
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
									<th>Operacion</th>
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
@include('tipoMovimiento.modal')
@endsection