@extends('admin_panel.index')


@section('content')
  

        
 <br>          
<a class="btn btn-primary  " href="{{route('materiaPrima.create')}}">New Materia Prima </a>

       <div class="card">
            <h1>Lista de Materias Primas</h1>
            
           <table class='table table-bordered table-striped table-hover datatable'>
               <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materiasPrimas as $materia)
                        <tr>
                            <th>
                                {{$materia->nombre}}
                            </th>
                            <th>
                                {{$materia->precioUnitario}}
                            </th>
                            <th>
                                {{$materia->cantidad}}
                            </th>
                            <th>
                                <div class="row align-items-start">

                                    <form method="POST" action="materiaPrima/{{$materia->id}}">
                                        <a type="button" class="btn btn-secondary btn-xs"  href='{{route('materiaPrima.edit',$materia->id)}}'>Editar</a>
                                        <a type="button" class="btn btn-secondary btn-xs"  href='{{route('materiaPrima.show',$materia->id)}}'>Ver mas..</a>

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs btn-delete">Borrar</button>
                                    </form>
                                </div>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    
                </table>
                
            </div>
            
   
@endsection