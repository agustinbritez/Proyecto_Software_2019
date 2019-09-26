@extends('admin_panel.index')


@section('content')



<br>          

<div class="conteiner">
  
  <div class="row">
    <div class="col-sm-12">
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


