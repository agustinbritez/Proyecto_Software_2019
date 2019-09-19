<div class="container-fluid">

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Categoria</h3>
    
        <div class="card-tools">
          {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> --}}
        </div>
      </div>
    
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
          {{-- Inicia todo los inpunt --}}
            <div class="form-group">
              <label for="">Nombre:</label>   
              <input  value="{{old('nombre') ??$categoria->nombre}}" class="form-control "  placeholder="Nombre de la Categoria" name="nombre">
           
              <label for="">Detalle:</label>   
              <input  value="{{old('detalle') ??  $categoria->detalle}}" class="form-control "  placeholder="Detalle" name="detalle">

    
            </div>
    {{-- Terminan los imput para crear --}}
          </div>
        </div>
      </div>
      <div class="card-footer">
        {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
        the plugin. --}}
      </div>
    </div>
    </div>
    
    

         
          
    
       