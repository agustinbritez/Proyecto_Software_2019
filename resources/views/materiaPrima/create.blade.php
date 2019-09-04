@extends('admin_panel.index')

@section('content')
    <form class="form-group" method="POST" action="/materiaPrima">
        @csrf {{-- Se utiliza para evitar injecciones  --}}
            <div class="form-group">
                    <label for="">Nombre</label>
                    <input  type="text" name="nombre" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Medida</label>
                <input  type="text" name="medida" class="form-control">
             </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    


@endsection
