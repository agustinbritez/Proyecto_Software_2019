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
					<h3>Filtro de Movimientos</h3>
				</div>


				<div class="card-body">
					<form action="{{route('pdf.movimiento')}}" method="GET" enctype="multipart/form-data">
						@csrf
						<div align="right">

							<button type="submit" class="btn  btn-success  btn-flat btn-sm">Reporte Movimientos</button>
						</div>
						<hr>
						<div class="row">

							<div class="form-group col ">
								<label class="control-label">Numero de Movimiento : </label>

								<input type="text" class="form-control text-left" name="filtro_id" id="filtro_id"
									placeholder="Numero de Movimiento" data-mask
									data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">

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

							<div class="form-group col">
								<label>Desde</label>
								<input type="date" id="min" name="desde" value="" class="form-control">
							</div>

							<div class="form-group col">
								<label>Hasta</label>
								<input type="date" id="max" name="hasta" value="" class="form-control">
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
					<h3>Lista de Movimientos</h3>
				</div>
				<div class="card-body">

					<div align="left">
						@if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin'))


						<button type="button" name="create_record" id="create_record"
							class="btn btn-success btn-sm">Crear Nuevo Movimientos</button>
						@endif

					</div>

					<hr>
					<div class="table-responsive ">
						<table class='table table-bordered table-striped table-hover datatable' id='data-table'>
							<thead style="background-color:white ; color:black;">
								<tr>
									<th>ID</th>
									<th>Materia Prima</th>
									<th>Precio Unitario</th>
									<th>Cantidad</th>
									<th>Operacion</th>
									<th>Tipo Movimiento</th>

									<th>Fecha</th>


								</tr>
							</thead>
							<tbody style="background-color:white ; color:black;">
								@if (sizeof($movimientos)>0)

								@foreach ($movimientos as $movimiento)
								<tr style="text-align: right">

									<td>{{$movimiento->id}} </td>
									<td class="text-left">
										{{$movimiento->materiaPrima->nombre . ' (' .$movimiento->materiaPrima->medida->nombre.')' }}
									</td>


									<td>

										{{number_format($movimiento->precioUnitario,2)}}


									</td>
									<td>

										{{number_format($movimiento->cantidad)}}


									</td>
									<td class="text-left">
										{{$movimiento->tipoMovimiento->operacion ? 'Suma' :'Resta'  }} </td>
									<td class="text-left">
										{{$movimiento->tipoMovimiento->nombre  }} </td>
									<td>{{$movimiento->getFechaMovimiento()}} </td>



								</tr>
								@endforeach
								@endif
							</tbody>

							<tfoot style="background-color:#ccc; color:white;">
								<tr>
									<th>ID</th>
									<th>Materia Prima</th>
									<th>Precio Unitario</th>
									<th>Cantidad</th>
									<th>Operacion</th>
									<th>Tipo Movimiento</th>

									<th>Fecha</th>

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
@include('movimiento.modal')
@endsection