@extends('admin_panel.index')

@section('content')
<div class="container-fluid">

    <form class="form-group" method="POST" action="{{route('materiaPrima.index')}}">
        @csrf {{-- Se utiliza para evitar injecciones  --}}
        @include('materiaPrima.form')
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
    
@endsection
