@extends('admin_panel.index')

@section('content')
<div class="container-fluid">

    <form class="form-group" method="POST" action="{{route('item.index')}}">
        @csrf {{-- Se utiliza para evitar injecciones  --}}
        @include('item.form')
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
    
@endsection
