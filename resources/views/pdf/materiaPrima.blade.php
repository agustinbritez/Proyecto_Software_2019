@extends('layouts.pdf2')
@section('content')

<div>
    <table id="titulo">
        <thead>
            <tr>
                <th id="fac">Listado de Materia Prima</th>
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
                            <span class="badge badge-info" >{{$modelo->nombre}}</span>&nbsp;&nbsp;
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
        {{$cant}}
        @endsection
        @stop
        