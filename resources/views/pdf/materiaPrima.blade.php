@extends('layouts.pdf2')


@section('content')
<div class="row" style="margin-bottom: 5px">
    <h5 class="text-center"><strong><u style="color:black"> Reporte de Materia Primas</u></strong></h5>
</div>

<div style="margin-bottom: 5px" ><strong> Filtros Aplicados: </strong> </div >
<div style="margin-bottom: 5px" >Nombre: {{$filtro_nombre ?? 'No aplicado'}}.</div >
<div style="margin-bottom: 5px" >Cantidad: {{$filtro_cantidad ?? 'No aplicado' }}.</div >
<div style="margin-bottom: 5px" >Modelo: {{$filtro_modelo->nombre ?? 'No aplicado' }}.</div>


{{-- <div> <h5>Lista de Materias Primas</h5></div> --}}
<br>
    <div class="table" style="font-family: Arial, Helvetica, sans-serif;">

        <table  class="table table-bordered" >
            <thead >
                <tr style="line-height: 14px; font-size: 14px; background: lightgrey">
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
                <tr >
                    <td>{{$materia->id}}</td>
                    <td>{{$materia->nombre}}</td>
                    <td>{{$materia->precioUnitario}}</td>
                    <td>{{$materia->cantidad}}</td>
                    <td>{{$materia->medida->nombre}}</td>
                    <td>
                        @foreach ($materia->modelos as $key=>$modelo)
                        <span ><strong> {{$modelo->nombre}}</strong> </span>&nbsp;&nbsp;
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
    {{sizeof($materiaPrimas)}}
    @endsection
    @stop
    