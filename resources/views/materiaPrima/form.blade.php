<div class="container-fluid">

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">Crear Materia Prima</h3>

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
          <input  value="{{old('nombre') ??$materiaPrima->nombre}}" class="form-control "  placeholder="Nombre de Materia Prima" name="nombre">
       
          <label for="">Detalle:</label>   
          <input  value="{{old('detalle') ??  $materiaPrima->detalle}}" class="form-control "  placeholder="Detalle" name="detalle">
  
          <label for="">Cantidad:</label>   
          <input  value="{{old('cantidad') ??  $materiaPrima->cantidad}}" class="form-control "  placeholder="Cantidad" name="cantidad">
  
          <label for="">Precio Unitario:</label>   
          <input  value="{{old('precioUnitario') ??  $materiaPrima->precioUnitario}}" class="form-control "  placeholder="Precio Unitario" name="precioUnitario">
  
          <label for="">Color:</label>   
          <input  value="{{old('color') ??  $materiaPrima->color}}" class="form-control "  placeholder="Color" name="color">
  
          <div class="form-group">
            <label>Tipo Materia Prima</label>
            <select class="form-control select2" style="width: 100%;" name="tipoMateriaPrima_id">

              
              @if($materiaPrima->tipoMateriaPrima!=null)
                @foreach ($tipoMateriaPrimas as $tipo)
                  @if ($tipo->id!=$materiaPrima->tipoMateriaPrima->id)
                  <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>  
                  
                  @else
                  <option selected="selected" value="{{$tipo->id}}" >{{$tipo->nombre}}</option>

                  @endif
                @endforeach
             @else
                @foreach ($tipoMateriaPrimas as $tipo)
                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option> 
                @endforeach
              @endif
                
              
            {{-- <option selected value="{{$materiaPrima->tipoMateriaPrima->id}}" >{{$materiaPrima->tipoMateriaPrima->nombre}}</option> --}}

            </select>
          </div>

          <div class="form-group">
              <label>Medida</label>
              <select class="form-control select2" style="width: 100%;"  name="medida_id">
              @if($materiaPrima->medida!=null)
                @foreach ($medidas as $medida)
                  @if ($medida->id!=$materiaPrima->medida->id)
                  <option value="{{$medida->id}}">{{$medida->nombre}}</option>  
                  
                  @else
                  <option selected="selected" value="{{$medida->id}}" >{{$medida->nombre}}</option>

                  @endif
                @endforeach
              @else
                @foreach ($medidas as $medida)
                <option value="{{$medida->id}}">{{$medida->nombre}}</option> 
                @endforeach
              @endif

              </select>
            </div>

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


      @push('scripts')
      <script>
        $(document).ready(function(){
          $('.select2').select2();
        });
      
      </script>
      @endpush
     
      

   