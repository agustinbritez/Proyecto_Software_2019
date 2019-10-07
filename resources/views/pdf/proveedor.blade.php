@extends('layouts.pdf2')


@section('content')
<div class="row" style="margin-bottom: 5px">
    <h5 class="text-center"><strong><u style="color:black"> Reporte de Proveedores</u></strong></h5>
</div>


<div style="margin-bottom: 5px"><strong> Filtros Aplicados: </strong> </div>
<div style="margin-bottom: 5px">Nombre: {{$filtro_nombre?? 'No aplicado'}}.</div>
<div style="margin-bottom: 5px">Documento: {{$filtro_documento ?? 'No aplicado' }}.</div>
<div style="margin-bottom: 5px">Email: {{$filtro_email ?? 'No aplicado'}}.</div>


{{-- <div> <h5>Lista de Materias Primas</h5></div> --}}
<br>
<div class="table" style="font-family: Arial, Helvetica, sans-serif;">
    
    
    <table  class="table table-bordered" >
        <thead>
            
            <tr style="line-height: 14px; font-size: 14px; background: lightgrey">
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Razon Social</th>
                <th>Documento </th>
                <th>Direccion </th>
                
            </tr>
        </thead>
        
        <tbody>
            @if (sizeof($proveedores)>0)
            
            @foreach ($proveedores as $proveedor)
            <tr>
                
                <th  >{{$proveedor->id}} </th>
                <th  >{{$proveedor->nombre}} </th>
                <th  >{{$proveedor->email}} </th>
                <th  >{{$proveedor->razonSocial}} </th>
                @if ($proveedor->documento!=null)
                <th  >{{$proveedor->documento->nombre .' - '.$proveedor->numeroDocumento}} </th>
                @else
                <th  >Sin Documento </th>
                @endif
                
                @if ($proveedor->direccion!=null)
                <th >
                        {{ $proveedor->direccion->calle . ' - '.$proveedor->direccion->numero . ' - '.
                        $proveedor->direccion->localidad . ' - '.$proveedor->direccion->provincia . ' - '
                        .$proveedor->direccion->pais }} 
                   
                </th>
                @else
                <th>Sin Direccion </th>
                @endif
                
                
                
            </tr>
            @endforeach
            @endif
        </tbody>
        
    </table>
</div>


@section('cantidad')
{{sizeof($proveedores)}}
@endsection
@stop