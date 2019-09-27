@extends('layouts.pdf')
@section('content')

</section>
<br>
<h3>Lista de Materia Primas</h3>
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
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Medida </th>
                    <th>Modelos </th>
                </tr>
            </thead>
            
            <tbody>
                
                @foreach ($materiaPrimas as $materia)
                <tr>
                    <td>{{$materia->id}}</td>
                    <td>{{$materia->nombre}}</td>
                    <td>{{$materia->precioUnitario}}</td>
                    <td>{{$materia->cantidad}}</td>
                    <td>{{$materia->medida->nombre}}</td>
                    <td>
                        @foreach ($materia->modelos as $key=>$modelo)
                        <span class="badge badge-dark" >{{$modelo->nombre}}</span>&nbsp;&nbsp;
                        @endforeach
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
            <tbody>
            </tbody>
            
        </table>
    </div>
    @section('cantidad')
    {{-- {{$cant}} --}}
    @endsection
    @stop
    