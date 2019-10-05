 
 <div id="formModal" class="modal fade" role="dialog">
    
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            
            <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-header">
                    
                    <h4 class="modal-title"> TITULO</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        
                        <ul></ul>
                        
                    </div>
                    <span id="form_result"></span>
                    @csrf
                    <div class="container">
                        <div class="form-group  ">
                            <label class="control-label" >Nombre: </label>
                            
                            <input type="text" name="nombre" id="nombre" required placeholder="Ingrese el Nombre del Documento" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-around" >
                    
                    <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>    
                    
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    
                </div>
                
            </form>
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
                <form id="formDelete" action="{{route('documento.destroy')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    {{-- Paso el id de la materia  aborrar en boton_delete--}}
                    <input type="hidden" name="boton_delete" id="boton_delete" >
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>




@push('scripts')
<script>
    
    
    $(document).ready(function(){
     
        var table= $('#data-table').DataTable({
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
                
            }
        });
        
        
        //mascaras******************************************************************************
        
        $('[data-mask]').inputmask();
        
        
        
        //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
        $('#create_record').click(function(){
            
            
            $('#form_result').html('');
            $("#sample_form").attr("action","{{route('documento.store')}}");
            $('.modal-title').text("Agregar Nuevo documento");
            $('#action_button').val("Agregar");
            $('#action').val("Add");
            $('#nombre').val('');
            
            $('#hidden_id').val('');
            
            $('#formModal').modal('show');
        });
        
        
        
        //el boton edit en el index que mostrara el modal
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $("#sample_form").attr("action","{{route('documento.update')}}");
            $('#form_result').html('');
            $.ajax({
                url:"/documento/"+id+"/edit",
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(html){
                 
                    //el data es la variable que contiene todo los atributos del objeto que se paso por la ruta
                    $('#nombre').val(html.data.nombre);

                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text("Editar Documento");
                    $('#action_button').val("Editar");
                    $('#action').val("Edit");
                    $('#formModal').modal('show');
                 
                }
            })
        });
        
        
        var id;
        $(document).on('click', '.delete', function(){
            id = $(this).attr('id');
            $('#boton_delete').val(id);
            $('#ok_button').text('Ok')
            $('.modal-title').text("Confirmacion");
            $('#confirmModal').modal('show');
        });
        
        $('#formDelete').on('submit',function(){
            $('#ok_button').text('Eliminando...')
        });
        
        
        
        
    });
</script>
@endpush


