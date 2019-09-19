@extends('admin_panel.index')


@section('content')



<br>          

<div class="conteiner">
	
	<div class="row">
		<div class="col-sm-12">
			<div class="card text-left">
				<div class="card-header">
					Lista de Materia Primas
				</div>
				<div class="card-body">
						<a class="btn btn-primary  " href="{{route('materiaPrima.create')}}">
								Agregar Nueva Materia Prima <span  class="fal fa-plus-circle"></span>
						</a>
					
					<hr>
					@include('materiaPrima.table')
				</div>
				<div class="card-footer text-muted">
					{{-- 2 days ago --}}
				</div>
			</div>
		</div>
	</div>
</div>



@endsection

