<div class="container">

    <table class='table table-bordered table-striped table-hover datatable' id='materiaPrimas'>
        <thead style="background-color:brown ; color:white;">
                <tr>
                     <th>Nombre</th>
                     <th>Precio Unitario</th>
                     <th>Cantidad</th>
                     <th >&nbsp; </th>
                    
                     
                    </tr>
             </thead>
            
             <tfoot style="background-color:#ccc; color:white;">
                 <tr>
                         <th>Nombre</th>
                         <th>Precio Unitario</th>
                         <th>Cantidad</th>
                         <th >&nbsp; </th>
                      
                 </tr>
                </tfoot>
             
         </table>
         
</div>

@push('scripts')
<script>
$(document).ready( function () {
  $('#materiaPrimas').DataTable({
    "serverSide": true,
    "ajax": "{{ url('api/materiaPrimas') }}",
    "columns": [

        {data: 'nombre'},
        {data: 'precioUnitario'},
        {data: 'cantidad'},
        {data: 'btn'},
    ]
  });
  
 } );


</script>
  
@endpush