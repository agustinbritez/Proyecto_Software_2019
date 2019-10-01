@extends('admin_panel.index')


@section('content')



<br>          

<div class="conteiner">
	
	<div class="row">
		<div class="col-sm-12">
			<div class="card text-left">
				
				<div class="card-header">
					
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
					<h3 >Filtro de Movimientos</h3>
				</div>
				
				
				<div class="card-body">
					<form action="{{route('pdf.proveedor')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<div align="right">
						
						<button type="submit"  class="btn  btn-success  btn-flat btn-sm">Reporte Movimiento</button>
					</div>
					<hr>
				<div class="row">
					
					<div class="form-group col-md-3">
						<label>Numero Movimiento : </label>
						<input class="form-control"  type="text" name="filtro_numeroMovimiento" id="filtro_numeroMovimiento" data-placeholder="Ingrese un nombre a filtrar"
						style="width: 100%;">
					</div>
					<div class="form-group col-md-3">
						<label>Precio Unitario : </label>
						<input class="form-control"  type="text" name="filtro_precioUnitario" id="filtro_precioUnitario" data-placeholder="Ingrese un nombre a filtrar"
						style="width: 100%;">
					</div>
					<div class="form-group col-md-3">
						<label>Cantidad : </label>
						<input class="form-control"  type="text" name="filtro_cantidad" id="filtro_cantidad" data-placeholder="Ingrese un nombre a filtrar"
						style="width: 100%;">
					</div>
					<div class="form-group col-md-3">
						<label>Fecha : </label>
						<input class="form-control"  type="text" name="filtro_fecha" id="filtro_fecha" data-placeholder="Ingrese un nombre a filtrar"
						style="width: 100%;">
					</div>
				
			</div>
		</form>
		</div>
		<div class="card-footer text-muted">
			<div class="text-center">
				<button type="button" name="filtrar" id="filtrar" class="btn btn-success btn-sm">Filtrar</button>
				<button type="button" name="reiniciar" id="reiniciar" class="btn btn-info btn-sm">Reiniciar Tabla</button>
			</div>
			
		</div>
	</div>
	
	<div class="card text-left">
		
		
		<div class="card-header">
			<h3>Lista de Movimientos</h3>
		</div>
		<div class="card-body">
			
			<div align="left">
				<button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Crear Nuevo Movimiento</button>
				
			</div>
			
			<hr>
			<div class="table-responsive ">
				<table class='table table-bordered table-striped table-hover datatable' id='data-table'>
					<thead style="background-color:white ; color:black;">
						<tr>
							<th>ID</th>
							<th>Precio</th>
							<th>Email</th>
							<th>Cantidad</th>
							<th>Fecha </th>
							<th >&nbsp; </th>
								
						</tr>
					</thead>
					<tbody style="background-color:white ; color:black;">
						{{-- @if (sizeof($proveedores)>0)
						
						@foreach ($proveedores as $proveedor)
						<tr>
							
							<th> </th>
							<th> </th>
							<th> </th>
							<th> </th>
							{{-- <th>Sin Documento  </th> --}}
						
							{{-- <th>{{$proveedor->documentos[0]->nombre .' - '.$proveedor->documentos[0]->numero}}  </th> --}}

							{{-- <th>Imagen Principal</th> --}}
							{{-- <th >
								<button type="button" name="edit" id="{{$proveedor->id}}" class="edit btn btn-outline-primary btn-sm">Editar</button>
								&nbsp;&nbsp;
								<button type="button" name="delete" id="{{$proveedor->id}}" class="delete btn btn-outline-danger btn-sm">Eliminar</button>
								
							</th>
							
							
						</tr>
						@endforeach
						@endif	 --}}
					</tbody>
					
					<tfoot style="background-color:#ccc; color:white;">
						<tr>
							<th>ID</th>
							<th>Precio</th>
							<th>Email</th>
							<th>Cantidad</th>
							<th>Fecha </th>
						
							{{-- <th>Imagen Principal</th> --}}
							<th >&nbsp; </th>
							
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
<script>
	$(document).ready(function(){
		$('.select2').select2(
			// {theme: 'bootstrap4'}
			);
		
	});
</script>
@endpush

@section('htmlFinal')
{{-- @include('proveedor.modal')    --}}
@endsection


