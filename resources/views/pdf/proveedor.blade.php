@extends('layouts.pdf')
@section('content')

{{-- </section>
<br>
<h3>Lista de Materia Primas</h3>
<section>
    <div>
        
        
        
    </div>
</section> --}}
<br>

    <div>
<br>
<br>
<br>
        <table  class="table table-bordered" >
            <thead>
                <tr >
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
                    
                    <th>{{$proveedor->id}} </th>
                    <th>{{$proveedor->nombre}} </th>
                    <th>{{$proveedor->email}} </th>
                    <th>{{$proveedor->razonSocial}} </th>
                    {{-- <th>Sin Documento  </th> --}}
                

                    @if (sizeof($proveedor->documentos)>0)
                    <th>{{$proveedor->documentos[0]->nombre .' - '.$proveedor->documentos[0]->numero}}  </th>
                    @else
                    <th>Sin Documento  </th>
                    @endif
                    
                    @if (empty($proveedor->direcciones))
                    <th>{{'Calle: '. $proveedor->direcciones[0]->calle .', Numero: '.$proveedor->direcciones[0]->numero}}  </th>
                    @else
                    <th>Sin Direccion  </th>
                    @endif
                   
                    
                    
                </tr>
                @endforeach
                @endif	
            </tbody>
            <tbody>
            </tbody>
            
        </table>
    </div>

    @section('cantidad')
    {{sizeof($proveedores)}}
    @endsection
    @stop
    