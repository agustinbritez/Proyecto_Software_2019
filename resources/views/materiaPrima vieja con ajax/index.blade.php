@extends('admin_panel.index')


@section('content')



<br>          

<div class="conteiner">
	
	<div class="row">
		<div class="col-sm-12">
		<form action="{{route('materiaPrima.pdf')}}" method="POST">
				<div class="card text-left">
					<div class="card-header">
						<h1>Filtro de  Materia Primas</h1>
					</div>
					
					<div class="card-body">
						{{-- <div class="form-group col-md-3">
							<label>Modelos : </label>
							<select class="select2"  name="filtro_modelo" data-placeholder="Seleccione Un Modelo"
							style="width: 100%;">
							@if(!empty($modelos))
							@foreach ($modelos as $modelo)
							<option value="{{$modelo->id}}">{{$modelo->nombre}}</option>  
							@endforeach
							
							@endif
							
							
						</select>
					</div> --}}
					<div class="form-group col-md-3">
						<label>Nombre : </label>
						<input class="form-control"  name="filtro_nombre" data-placeholder="Ingrese un nombre a filtrar"
						style="width: 100%;">
					</div>
				</div>
				<div class="card-footer text-muted">
					<div class="text-center">
						
						<button type="submit" name="create_record" id="create_record" class="btn btn-success btn-sm">Filtrar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="card text-left">
	
	
	<div class="card-header">
		<h1>Lista de Materia Primas</h1>
	</div>
	<div class="card-body">
		
		<div align="left">
			<button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Crear Nueva Materia Prima</button>
			
			<a type="button"  href="{{route('materiaPrima.pdf')}}" class="btn btn-success btn-sm">Reporte Materia Prima</a>
		</div>
		
		<hr>
		<div class="table-responsive ">
			<table class='table table-bordered table-striped table-hover datatable' id='data-table'>
				<thead style="background-color:white ; color:black;">
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Precio Unitario</th>
						<th>Cantidad</th>
						<th>Medida </th>
						<th>Modelos </th>
						{{-- <th>Imagen Principal</th> --}}
						<th >&nbsp; </th>
						
						
					</tr>
				</thead>
				
				<tfoot style="background-color:#ccc; color:white;">
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Precio Unitario</th>
						<th>Cantidad</th>
						<th>Medida </th>
						<th>Modelos </th>
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
		$('.select2').select2();
	});
	
</script>
@endpush

@section('htmlFinal')
@include('materiaPrima.modal')   
@endsection


