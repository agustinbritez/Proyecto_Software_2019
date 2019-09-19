@extends('admin_panel.index')


@section('content')



<br>          

<div class="conteiner">
	
	<div class="row">
		<div class="col-sm-12">
			<div class="card text-left">
				<div class="card-header">
					Lista de Items
				</div>
				<div class="card-body">
						<a class="btn btn-primary  " href="{{route('item.create')}}">
								Agregar Nuevo Item <span  class="fal fa-plus-circle"></span>
						</a>
					
					<hr>
					@include('item.table')
				</div>
				<div class="card-footer text-muted">
					{{-- 2 days ago --}}
				</div>
			</div>
		</div>
	</div>
</div>



@endsection

