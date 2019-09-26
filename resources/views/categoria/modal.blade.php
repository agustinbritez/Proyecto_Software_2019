 
 <div id="formModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Add New Record</h4>
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
          

          <div class="form-group " >
              
                  <label class="control-label">Base : </label>
              
                  <input name="base" id="base" type="checkbox" value=""  aria-label="Checkbox for following text input">
              
            </div>

          <br />
          <div class="form-group" align="center">
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Add" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
      processing: false,
      serverSide: true,
      ajax:{
        url: "{{ route('categoria.index') }}",
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
        data: 'action',
        name: 'action',
        orderable: false
      }
      ]
    });

    $('#base').click( function(){
      if(this.checked){
        $('#base').val(0);
      }else{
        $('#base').val(1);
        // alert($('#base').val());
      }
    });


    //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
    $('#create_record').click(function(){
      $('#form_result').html('');
      $('.modal-title').text("Agregar Nueva Categoria");
      $('#action_button').val("Agregar");
      $('#action').val("Add");
      $('#formModal').modal('show');
      $('#nombre').val('');
      $('#detalle').val('');
      $('#hidden_id').val('');
      $('#base').prop("checked", false); 
    });
    
    //el boton edit en el index que mostrara el modal
    $(document).on('click', '.edit', function(){
      var id = $(this).attr('id');
      $('#form_result').html('');
      $.ajax({
        url:"/categoria/"+id+"/edit",
        dataType:"json",
        success:function(html){
          $('#nombre').val(html.data.nombre);
          $('#detalle').val(html.data.detalle);
          $('#hidden_id').val(html.data.id);
          if(html.data.base==0)
          {
            $('#base').prop("checked", true); 
          }else{
            $('#base').prop("checked", false); 
          }
          $('.modal-title').text("Editar Categoria");
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
              url:"{{ route('categoria.store') }}",
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
                url:"{{ route('categoria.update') }}",
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
                      //$('#sample_form')[0].reset();
                      $('#data-table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                  }
                });
              }
            });
            
            
            var categoria_id;
            
            $(document).on('click', '.delete', function(){
              categoria_id = $(this).attr('id');
              $('#ok_button').text('Ok')
              $('.modal-title').text("Confirmacion"); 
              $('#confirmModal').modal('show');
            });
            
            $('#ok_button').click(function(){
              $.ajax({
                url:"categoria/destroy/"+categoria_id,
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
        
        