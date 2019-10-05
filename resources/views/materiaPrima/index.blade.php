@extends('admin_panel.index')


@section('content')



<br>          

<div class="container">
	
	<div class="row">
		<div class="col">
			<div class="card text-left">
				
				<div class="card-header">
					
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
					<h3 >Filtro de  Materia Primas</h3>
				</div>
				
				
				<div class="card-body">
					<form action="{{route('pdf.materiaPrima')}}" method="GET" enctype="multipart/form-data">
						@csrf
						<div align="right">
							
							<button type="submit"  class="btn  btn-success  btn-flat btn-sm">Reporte Materia Prima</button>
						</div>
						<hr>
						<div class="row">
							
							<div class="form-group col-md-3">
								<label>Nombre : </label>
								<input class="form-control"  type="text" name="filtro_nombre" id="filtro_nombre" data-placeholder="Ingrese un nombre a filtrar"
								style="width: 100%;">
							</div>
							<div class="form-group col-md-3">
								<label>Cantidad : </label>
								<input class="form-control"  type="number" name="filtro_cantidad" id="filtro_cantidad" style="width: 100%;">
							</div>
							<div class="form-group col-md-3">
								<label>Modelo : </label>
								<select class="select2"  name="filtro_modelo" id="filtro_modelo" data-placeholder="Seleccione Un Modelo"
								style="width: 100%;">
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
					<button type="button" name="filtrar" id="filtrar" class="btn btn-success btn-sm">Filtrar</button>
					<button type="button" name="reiniciar" id="reiniciar" class="btn btn-info btn-sm">Reiniciar Tabla</button>
				</div>
			</div>
		
	</div>
	
	<div class="card text-left">
		
		
		<div class="card-header">
			<h3>Lista de Materia Primas</h3>
		</div>
		<div class="card-body">
			
			<div align="left">
				<button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Crear Nueva Materia Prima</button>
				
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
							<th>Medida </th>
							<th>Modelos </th>
							{{-- <th>Imagen Principal</th> --}}
							<th >&nbsp; </th>
							
							
						</tr>
					</thead>
					<tbody style="background-color:white ; color:black;">
						@if (sizeof($materiaPrimas)>0)
						
						@foreach ($materiaPrimas as $materia)
						<tr>
							
							<th>{{$materia->id}} </th>
							
						<th><img src="{{asset("/imagenes/materia_primas/".$materia->imagenPrincipal)}}" alt="" width='70px' height='70px'></th>
							<th>{{$materia->nombre}} </th>
							<th>{{$materia->precioUnitario}} </th>
							<th>{{$materia->cantidad}} </th>
							<th>{{$materia->medida->nombre}}  </th>
							<th>
								@if (sizeof($materia->modelos)>0)
								
								@foreach ($materia->modelos as $modelo)
								
								<span class="badge badge-info" id="modelo_{{$modelo->id}}" >{{$modelo->nombre}}</span>&nbsp;&nbsp;
								@endforeach
								@endif
								
							</th>
							{{-- <th>Imagen Principal</th> --}}
							<th >
								<button type="button" name="edit" id="{{$materia->id}}" class="edit btn btn-outline-primary btn-sm">Editar</button>
								&nbsp;&nbsp;
								<button type="button" name="delete" id="{{$materia->id}}" class="delete btn btn-outline-danger btn-sm">Eliminar</button>
								
							</th>
							
							
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



@section('htmlFinal')
@include('materiaPrima.modal')   
@endsection


