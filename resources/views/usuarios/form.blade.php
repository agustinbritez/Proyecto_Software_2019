<div class="form-group">
        <label for="">Nombre:</label>   
        <input  value="{{old('nombre') ??$usuario->nombre}}" class="form-control "  placeholder="Nombre del Usuario" name="nombre">
      </div>
  
      <div class="form-group">
        <label for="">Apellido:</label>   
        <input  value="{{old('apellido') ??  $usuario->apelldio}}" class="form-control "  placeholder="Apellido del Usuario" name="apellido">
</div>
<div class="form-group">
        <label for="">Documento:</label>   
        <input  value="{{old('documento') ??  $usuario->documento}}" class="form-control "  placeholder="Numero de Documento" name="documento">
</div>

<div class="form-group">
        <label for="">Password:</label>   
        <input  value="" class="form-control "  placeholder="Ingrese su contraseña" name="password">
</div>

<div class="form-group">
        <label for="">Email:</label>   
        <input  value="{{old('email') ??  $usuario->email}}" class="form-control "  placeholder="Ingrese su correo electronico" name="email">
</div>
