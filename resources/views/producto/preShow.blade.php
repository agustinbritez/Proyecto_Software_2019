@extends('admin_panel.index')
@section('style')
<style>
  .resize-drag {
    background-color: #29e;
    color: white;
    font-size: 20px;
    font-family: sans-serif;
    border-radius: 10%;
    /* padding: 20px; */
    margin: 30px 20px;
    touch-action: none;
    user-select: none;
    width: 120px;

    /* This makes things *much* easier */
    box-sizing: border-box;
  }

  .resize-container {
    display: inline-block;
    width: 480px;
    height: 720px;
    background-repeat: no-repeat;
  }
</style>
@endsection

@section('content')



<br>


<div class=" ">


  <div class="row justify-content-around ">

    <div class="col">
      <form action="" method="POST" enctype="multipart/form-data" name="form_materiasPrimas" id="form_materiasPrimas">
        @csrf
        <div class="card text-left">

          <div class="card-header">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                  class="fas fa-minus"></i></button>
            </div>
            <h3 class="text-center">Personalice su producto</h3>
          </div>
          {{-- Se le pasa todos los modelos que tiene materia primas asociadas directamente en su recetas --}}
          <div class="card-body">
            <div align="center">

              <div class=" resize-container" style="background-image: url('{{asset("/imagenes/modelos/".$producto->modelo->imagenPrincipal)??'' }}');
                  ">
                <img src="{{asset("/imagenes/modelos/".$producto->modelo->imagenPrincipal)??'' }}" class="resize-drag"
                  id="resize-drag">

              </div>

            </div>

            <p>posicion x: {{$producto->sublimaciones[0]->posX}}</p>
            <p>posicion y: {{$producto->sublimaciones[0]->posY}}</p>
          </div>



          <div class="card-footer text-muted justify-content-center">
          </div>
        </div>
      </form>
    </div>


  </div>

</div>


@endsection

@section('htmlFinal')

@endsection

@push('scripts')
<script>
  $(document).ready(function(){
      
      
      //cargar imagen local de forma dinamica
      document.getElementById("imagenNueva").onchange = function(e) {
        // Creamos el objeto de la clase FileReader
        let reader = new FileReader();
        
        // Leemos el archivo subido y se lo pasamos a nuestro fileReader
        reader.readAsDataURL(e.target.files[0]);
        
        // Le decimos que cuando este listo ejecute el código interno
        reader.onload = function(){
          let preview = document.getElementById('preview');
          image = document.createElement('img');
          image.src = reader.result;
          image.height='200';
          image.width='200';
          preview.innerHTML = '';
          preview.append(image);
          // alert(image.src);
          document.getElementById('resize-drag').src=image.src;
          // $('.resize-drag').src(image.src);
        };
        
      }
      
    });
    
    interact('.resize-drag')
    .draggable({
      onmove: window.dragMoveListener,
      modifiers: [
      interact.modifiers.restrictRect({
        restriction: 'parent'
      })
      ]
    })
    .resizable({
      // resize from all edges and corners
      edges: { left: true, right: true, bottom: true, top: true },
      
      modifiers: [
      // keep the edges inside the parent
      interact.modifiers.restrictEdges({
        outer: 'parent',
        endOnly: false
      }),
      
      // minimum size
      interact.modifiers.restrictSize({
        min: { width: 100, height: 50 }
      })
      ],
      
      inertia: true
    })
  );
    
    function dragMoveListener(event) {
      var target = event.target
      // keep the dragged position in the data-x/data-y attributes
      
      // var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
      // var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy
      var x = (parseFloat('{{$producto->sublimaciones[0]->posX}}'))
      var y = (parseFloat('{{$producto->sublimaciones[0]->posY}}'))
      
      target.style.width = (parseFloat('{{$producto->sublimaciones[0]->ancho}}')) + 'px' 
      target.style.height = (parseFloat('{{$producto->sublimaciones[0]->alto}}'))  + 'px'
      // translate the element
      target.style.webkitTransform =
      target.style.transform =
      'translate(' + x + 'px, ' + y + 'px)'
      
      // update the posiion attributes
      target.setAttribute('data-x', x)
      target.setAttribute('data-y', y)
    }
    
    // this is used later in the resizing and gesture demos
    window.dragMoveListener = dragMoveListener;
    
</script>

@endpush