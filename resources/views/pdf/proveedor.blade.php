@extends('layouts.pdf2')
@section('content')

<div>
    <table id="titulo">
        <thead>
            <tr>
                <th id="fac">Listado de Proveedores</th>
            </tr>
        </thead>
        <tbody>
{{--
            <tr>

                <th><p id="cliente"> Desde: <br>

                Hasta: </p></th>

            </tr> --}}

        </tbody>
    </table>
</div>
</section>
<br>
<section>
<div>



</div>
</section>
<br>
<section>
<div>
    <table id="lista">
        <thead>
            <tr id="fa">
            <th>Nr</th>
            <th>Nombre</th>
                <th>Cuit</th>
                <th>Email</th>
                <th>Telefono</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($proveedores as $prov)
            <tr>
            <td>{{$prov->id}}</td>
                <td>{{$prov->nombre}}</td>
                <td>{{$prov->cuit}}</td>
                <td>{{$prov->email}}</td>
                <td>{{$prov->telefono}}</td>
            </tr>
            @endforeach
        </tbody>
        <tbody>
        </tbody>

    </table>
</div>
@section('cantidad')
    {{$cant}}
@endsection
@stop
