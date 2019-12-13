<div id="formModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">

            <div class="modal-header">
                <div class="text-center">

                    <h4 class="modal-title"> TITULO</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="text-center">

                    <p>Seleccione el modelo que usara como base para crear su producto.</p>
                </div>
                <div class="row">
                    @foreach ($modelosVentas as $modelo)
                    <div class="form-group">
                        <div class="col">
                            <form action="{{ route('producto.create', $modelo->id) }}">

                                <div class="card" style="width: 18rem; ">
                                    <img src="{{ asset('/imagenes/modelos/'.$modelo->imagenPrincipal) }}"
                                        class="card-img-top" alt="..." height="250 px">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="text-justify"> </div>
                                            <h5 class="text-dark contenido" title="{{$modelo->nombre}}">
                                                {{$modelo->nombre}}</h5>
                                            <h5 class="text-dark contenido" title="{{$modelo->nombre}}">
                                                ${{number_format($modelo->precioUnitario,2)}}</h5>

                                            <input type="submit" name="action_button" id="action_button"
                                                class="btn btn-info btn-sm" value="Diseñar Producto" />
                                        </div>


                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="modal-footer justify-content-around">


            </div>


        </div>
    </div>
</div>






@push('scripts')
<script>
    $(document).ready(function(){
            
            
            
            
            //mascaras******************************************************************************
            
            //si se da un clic en el boton crear nuevo producto el valor del action cambiara a Add
            $('#create_record').click(function(){
                $('.modal-title').text("Modelos para el producto");
                
                $('#formModal').modal('show');
            });
            
        });
        $('.agregarCarrito').click(function(){
            var id= $(this).attr('data-id');
            url2="{{route('pedido.agregarProductoFinal',":id")}}";
            
            url2=url2.replace(':id',id);
            
            $.ajax({
                // async:false,
                
                type: 'GET',
                url: url2,
                success: function(data) {
                    // console.log(data);
                    var mensaje='';
                    $('#avisos').html('');
                    if(data!=null){
                        if(data['errors']){
                            mensaje='<div class="alert alert-danger alert-dismissible">'
                            +'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                            +data['errors']
                            +'</div>';
                        }
                        if(data['success']){
                            mensaje='<div class="alert alert-success alert-dismissible">'
                            +'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                            +data['success']
                            +'</div>';  
                        }
                        if(data['warning']){
                            mensaje='<div class="alert alert-warning alert-dismissible">'
                            +'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                            +data['warning']
                            +'</div>';   
                        }
                        // $('#avisos').html("");
                        $('#avisos').html(mensaje);
                        
                    }
                },
                error:function(){
                    alert('error');
                }
            });
        });
        $('#reiniciar').click(function(){
            $('#reiniciarTodaLaVista').submit();
        });
</script>

<script>
    $('#filtro_precioUnitarioMin').val('{{$vuelto->filtro_precioUnitarioMin ??""}}');
            $('#filtro_precioUnitarioMax').val('{{$vuelto->filtro_precioUnitarioMax ?? ""}}');

            $('#modelos').val('{{$vuelto->modelos ?? "-1"}}');
            $('#tipoImagen').val('{{$vuelto->tipoImagen ?? "-1"}}');
            $('#imagenSeleccionada').val('{{$vuelto->imagenSeleccionada ?? "-1"}}');
            $('#precios').val('{{$vuelto->precios ?? "-1"}}');
</script>
@endpush