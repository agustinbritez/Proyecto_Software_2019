@extends('layouts.pdf2')


@section('content')
<div class="row" style="margin-bottom: 5px">
    @if ($base)
        
    <h5 class="text-center"><strong><u style="color:black"> Reporte de Opciones de Productos</u></strong></h5>
    @else
    <h5 class="text-center"><strong><u style="color:black"> Reporte de Productos Bases</u></strong></h5>
        
    @endif
</div>

<div style="margin-bottom: 5px"><strong> Filtros Aplicados: </strong> </div>
<div style="margin-bottom: 5px">Nombre:
    {{' '}}<strong>{{$filtro_nombre_modelo ?? ' No aplicado '}}</strong>.</div>
<div style="margin-bottom: 5px">Precio Unitario Minimo:
    {{' '}}<strong>{{$filtro_precio_unitario_minimo?? ' No aplicado' }}</strong>.</div>
<div style="margin-bottom: 5px">Precio Unitario Maximo:
    {{' '}}<strong>{{$filtro_precio_unitario_maximo?? ' No aplicado' }}</strong> .</div>
<hr>
<div style="margin-bottom: 5px">
    <p>Cantidad Total de Registrados:<strong> {{($cantidadRegistros)}}
        </strong> </p>.
</div>




{{-- <div> <h5>Lista de Materias Primas</h5></div> --}}

<div class="table" style="font-family: Arial, Helvetica, sans-serif;">

    <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
        <thead style="background-color:white ; color:black;">
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio Unitario</th>
                {{-- <th>Receta</th> --}}


            </tr>
        </thead>
        <tbody style="background-color:white ; color:black;">
            @if (sizeof($modelos)>0)

            @foreach ($modelos as $modelo)
            <tr>

                <td>{{$modelo->id}} </td>

                <td><img src="{{asset("/imagenes/modelos/".$modelo->imagenPrincipal)}}" alt="" width='70px'
                        height='70px'></td>
                <td>{{$modelo->nombre??'Sin nombre'}} </td>
                <td align="right">{{ number_format($modelo->precioUnitario,2)??'Sin precio'}} </td>
                {{-- <td>
                    @if ($modelo->recetaPadre!=null)

                    @foreach ($modelo->recetaPadre as $receta)
                    @if ($receta->modeloHijo!=null)
                    <span class="badge badge-info"
                        id="{{$receta->id}}">{{$receta->modeloHijo->nombre}}</span>&nbsp;&nbsp;

                @else

                <span class="badge badge-info" id="{{$receta->id}}">{{$receta->materiaPrima->nombre}}</span>&nbsp;&nbsp;
                @endif
                @endforeach
                @endif

                </td> --}}


            </tr>
            @endforeach
            @endif
        </tbody>


    </table>
</div>

@section('cantidad')
{{sizeof($modelos)}}
@endsection
@stop