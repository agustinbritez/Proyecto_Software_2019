@extends('admin_panel.index')

@section('content')
    <form class="form-group" method="POST" action="/materiaPrima">
        @csrf {{-- Se utiliza para evitar injecciones  --}}
            @include('materiaPrima.form')
            <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    
@endsection
