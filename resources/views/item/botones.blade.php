<a type="button"   href="{{route('item.show',$id)}}"> 
    <span  class="btn btn-primary btn-xs" >
            <span class="fas fa-alt"> Ver Mas</span>
    </span>
</a>
<a type="button"   href="{{route('item.edit',$id)}}"> 
    <span  class="btn btn-primary btn-xs" >
            <span class="fas fa-pencil-alt"> Editar</span>
    </span>
</a>

<a  href="{{route('item.destroy',$id)}}"  onclick="return confirm('¿Seguro que desea eliminarlo?')"> 
            <span  class="btn btn-danger btn-xs" >
                    <span class="fas fa-tresh-alt"> Borrar</span>
            </span>
</a>
