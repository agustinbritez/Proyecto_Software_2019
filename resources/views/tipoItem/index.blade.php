@extends('admin_panel.index')


@section('content')



<br>          

<div class="conteiner">
  
  <div class="row">
    <div class="col-sm-12">
      <div class="card text-left">
        <div class="card-header">
          <h1>Lista de Tipo de Item</h1>
        </div>
        <div class="card-body">
          
          <div align="left">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Crear Nuevo Tipo Item</button>
           </div>
          
          <hr>
          <div class="table-responsive">
              <table class="table table-bordered table-striped" id="data-table">
                     <thead>
                      <tr>
                          <th >ID</th>
                          <th>Nombre</th>
                          <th>Detalle</th>
                          <th>Flujo de Trabajo</th>
                          <th>Categoria</th>
                          <th>Medida</th>
                          <th>Accion</th>
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
@include('tipoItem.modal')   
@endsection

