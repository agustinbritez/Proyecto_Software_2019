 
 <div id="formModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title"> TITULO</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <span id="form_result"></span>
        <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf
          
          <div class="form-group">
            <label class="control-label col-md-4" >Nombre: </label>
            <div class="col-md-8">
              <input type="text" name="nombre" id="nombre" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-4">Detalle : </label>
            <div class="col-md-8">
              <input type="text" name="detalle" id="detalle" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label>Flujos de Trabajos</label>
            <select class="form-control select2" style="width: 100%;" id="flujoTrabajo_id" name="flujoTrabajo_id">
              
              
              
              @foreach ($flujosTrabajos as $flujo)
              <option value="{{$flujo->id}}">{{$flujo->nombre}}</option>  
              
              @endforeach
            </select>
          </div>
          
          
          
          <div class="form-group">
            <label>Categoria</label>
            <select class="form-control select2" style="width: 100%;" id="categoria_id" name="categoria_id">
              
              
              {{-- @if($tipo->categoria!=null) --}}
              @foreach ($categorias as $cat)
              {{-- @if ($cat->id!=$tipo->categoria->id) --}}
              <option value="{{$cat->id}}">{{$cat->nombre}}</option>  
              
              {{-- @else --}}
              {{-- <option selected="selected" value="{{$cat->id}}" >{{$cat->nombre}}</option> --}}
              
              {{-- @endif --}}
              @endforeach
              {{-- @else
                @foreach ($categorias as $cat)
                <option value="{{$cat->id}}">{{$cat->nombre}}</option> 
                @endforeach
                @endif --}}
                
              </select>
            </div>
            
            <div class="form-group">
              <label>Medida</label>
              <select class="form-control select2" style="width: 100%;" id="medida_id" name="medida_id">
                
                
                {{-- @if($tipo->medida!=null) --}}
                @foreach ($medidas as $medida)
                {{-- @if ($medida->id!=$tipo->medida->id) --}}
                <option value="{{$medida->id}}">{{$medida->nombre}}</option>  
                
                {{-- @else --}}
                {{-- <option selected="selected" value="{{$medida->id}}" >{{$medida->nombre}}</option> --}}
                
                {{-- @endif --}}
                @endforeach
                {{-- @else
                  @foreach ($medidas as $medida)
                  <option value="{{$medida->id}}">{{$medida->nombre}}</option> 
                  @endforeach
                  @endif --}}
                  
                </select>
              </div>
              
              <br />
              <div class="form-group" align="center">
                <input type="hidden" name="action" id="action" />
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Add" />
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <div id="confirmModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Confirmacion</h2>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <h4 align="center" style="margin:0;">¿Esta seguro que desea borrarlo?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    
    
    
    <script>
      $(document).ready(function(){
        
        $('#data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax:{
            url: "{{ route('tipoItem.index') }}",
          },
          
          columns:[
          {
            data: 'id',
            name: 'id'
          },
          {
            data: 'nombre',
            name: 'nombre'
          },
          {
            data: 'detalle',
            name: 'detalle'
          },
          {
            data: 'flujoTrabajo',
            name: 'flujoTrabajo'
          },
          {
            data: 'categoria',
            name: 'categoria',
          },
          {
            data: 'medida',
            name: 'medida'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false
          }
          ]
        });
        
        //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
        $('#create_record').click(function(){
          $('#form_result').html('');
          $('.modal-title').text("Agregar Nueva Tipo Item");
          $('#action_button').val("Add");
          $('#action').val("Add");
          $('#formModal').modal('show');
          $('#nombre').val('');
          $('#detalle').val('');
          $('#hidden_id').val('');
        });
        //el boton edit en el index que mostrara el modal
        $(document).on('click', '.edit', function(){
          var id = $(this).attr('id');
          $('#form_result').html('');
          $.ajax({
            url:"/tipoItem/"+id+"/edit",
            dataType:"json",
            success:function(html){
              //el data es la variable que contiene todo los atributos del objeto que se paso por la ruta
              $('#nombre').val(html.data.nombre);
              $('#detalle').val(html.data.detalle);
              $("#flujoTrabajo_id option[value='"+ html.data.flujoTrabajo_id +"']").attr("selected",true);
              $("#medida_id option[value='"+ html.data.medida_id +"']").attr("selected",true);
              $("#categoria_id option[value='"+ html.data.categoria_id +"']").attr("selected",true);
              $('#hidden_id').val(html.data.id);
              $('.modal-title').text("Editar tipoItem");
              $('#action_button').val("Editar");
              $('#action').val("Edit");
              $('#formModal').modal('show');
            }
          })
        });

        
        $('#sample_form').on('submit', function(event){
          event.preventDefault();
          if($('#action').val() == 'Add')
          {
            $.ajax({
              url:"{{ route('tipoItem.store') }}",
              method:"POST",
              data: new FormData(this),
              contentType: false,
              cache:false,
              processData: false,
              dataType:"json",
              success:function(data)
              {
               
                var html = '';
                if(data.errors)
                {
                  html = '<div class="alert alert-danger">';
                    for(var count = 0; count < data.errors.length; count++)
                    {
                      html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                  }
                  if(data.success)
                  {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    $('#data-table').DataTable().ajax.reload();
                  }
                  $('#form_result').html(html);
                }
              })
            }
            
            //boton action dentro del modal osea guardar se activa la actualizacion
            if($('#action').val() == "Edit")
            {
              
              $.ajax({
                url:"{{ route('tipoItem.update') }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType:"json",
                success:function(data)
                {
                  var html = '';
                  if(data.errors)
                  {
                    html = '<div class="alert alert-danger">';
                      for(var count = 0; count < data.errors.length; count++)
                      {
                        html += '<p>' + data.errors[count] + '</p>';
                      }
                      html += '</div>';
                    }
                    if(data.success)
                    {
                      html = '<div class="alert alert-success">' + data.success + '</div>';
                      //blanquea todo campos de entrda del modal
                      // $('#sample_form')[0].reset();
                      $('#data-table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                  }
                });
              }
            });
            
            
            var id;
            
            $(document).on('click', '.delete', function(){
              id = $(this).attr('id');
              $('#ok_button').text('Ok')
              $('#confirmModal').modal('show');
            });
            
            $('#ok_button').click(function(){
              $.ajax({
                url:"tipoItem/destroy/"+id,
                beforeSend:function(){$('#ok_button').text('Eliminando...');},
                success:function(data){
                  setTimeout(function(){
                    $('#confirmModal').modal('hide');
                    $('#data-table').DataTable().ajax.reload();
                  }, 0);
                  
                }
              })
            });
            
          });
        </script>
        
        