@extends('admin_panel.index')


@section('content')



<div width="50%">
    {!! $estadistica->container()!!}
</div>

{!! $estadistica->script()!!}


@endsection



@section('htmlFinal')
@endsection