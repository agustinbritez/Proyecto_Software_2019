@extends('admin_panel.index')


@section('content')



<br>          

<div class="conteiner">
  
  <div class="row">
    <div class="col-sm-12">
      <div class="card text-left">
        <div class="card-header">
          <h1>Lista de categorias</h1>
        </div>
        <div class="card-body">
          
          <div align="left">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Crear Nueva Categoria</button>
           </div>
          
          <hr>
          <div class="table-responsive">
              <table class="table table-bordered table-striped" id="data-table">
                     <thead>
                      <tr>
                          <th width="5%">ID</th>
                          <th width="30%">Nombre</th>
                          <th width="30%">Detalle</th>
                          <th width="35%">Accion</th>
                      </tr>
                     </thead>
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
@include('categoria.modal')   
@endsection

