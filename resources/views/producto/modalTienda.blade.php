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

                                <div class="card" style="width: 15rem; ">
                                    <img src="{{ asset('/imagenes/modelos/'.$modelo->imagenPrincipal) }}"
                                        class="card-img-top" alt="..." height="250 px">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="text-justify"> </div>
                                            <h5 class="text-dark contenido" title="{{$modelo->nombre}}">
                                                {{$modelo->nombre}}</h5>


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
</script>
@endpush