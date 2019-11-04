@extends('admin_panel.index')

@section('style')
<style>
  .resize-drag {
    background-color: #29e;
    color: white;
    font-size: 20px;
    font-family: sans-serif;
    border-radius: 8px;
    padding: 20px;
    margin: 30px 20px;
    touch-action: none;

    width: 120px;

    /* This makes things *much* easier */
    box-sizing: border-box;
  }

  .resize-container {
    display: inline-block;
    width: 100%;
    height: 240px;
  }
</style>
@endsection

@section('content')

<div class="resize-container">
  <div class="resize-drag">
    Resize from any edge or corner
  </div>
</div>

@endsection

@push('scripts')
  <script>
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
          endOnly: true
        }),

        // minimum size
        interact.modifiers.restrictSize({
          min: { width: 100, height: 50 }
        })
      ],

      inertia: true
    })
    .on('resizemove', function (event) {
      var target = event.target
      var x = (parseFloat(target.getAttribute('data-x')) || 0)
      var y = (parseFloat(target.getAttribute('data-y')) || 0)

      // update the element's style
      target.style.width = event.rect.width + 'px'
      target.style.height = event.rect.height + 'px'

      // translate when resizing from top or left edges
      x += event.deltaRect.left
      y += event.deltaRect.top

      target.style.webkitTransform = target.style.transform =
          'translate(' + x + 'px,' + y + 'px)'

      target.setAttribute('data-x', x)
      target.setAttribute('data-y', y)
      target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height)
    })
    function dragMoveListener(event) {
          var target = event.target
          // keep the dragged position in the data-x/data-y attributes
          var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
          var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy

          // translate the element
          target.style.webkitTransform =
              target.style.transform =
              'translate(' + x + 'px, ' + y + 'px)'

          // update the posiion attributes
          target.setAttribute('data-x', x)
          target.setAttribute('data-y', y)
      }

  // this is used later in the resizing and gesture demos
  window.dragMoveListener = dragMoveListener 
  </script>
@endpush

@section('htmlFinal')

@endsection