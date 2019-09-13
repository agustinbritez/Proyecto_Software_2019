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

        <label for="">Tipo Materia Prima:</label>   
        <select class="select2" multiple="multiple" data-placeholder="Select a State"
        style="width: 100%;" name="Tipo Materia Primas" >
          @foreach ($tipoMateriaPrimas as $tipo)
             <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>    
          @endforeach
          
        </select>
        <label>Multiple</label>
        <select class="select2 form-control" multiple="multiple" data-placeholder="Select a State"
                style="width: 100%;">
          <option>Alabama</option>
          <option>Alaska</option>
          <option>California</option>
          <option>Delaware</option>
          <option>Tennessee</option>
          <option>Texas</option>
          <option>Washington</option>
        </select>
      </div>
      </div>

   