@extends('admin_panel.index')


@section('content')



<br>          

<div class="conteiner">
  
  <div class="row">
    <div class="col-sm-12">
      <div class="card text-left">
        <div class="card-header">
          <h1>Lista Items</h1>
        </div>
        <div class="card-body">
          
          <div align="left">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Crear Nuevo Item</button>
			<select name="tipoItem" id="tipoItem">
				<option value="todos">Todos</option>
			</select>
		</div>
		   @foreach ($items as $item)
			   
		   <div class="card" style="width: 18rem;">
		   <img src="{{$item->imagenPrincipal->ruta}}" class="card-img-top" id="imagen" alt="...">
			<div class="card-body">
			<h5 class="card-title"> {{$item->nombre}}</h5>
			<p class="card-text">{{$item->detalle}}</p>
			<div class="card-body">
					<p class="card-text">${{$item->precio}}</p>
			</div>
			<a href="#" class="btn btn-primary">Editar</a>
			</div>
			</div>
		@endforeach
          
          <hr>
          <div class="table-responsive">
              
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
@include('categoria.modal')   
@endsection

