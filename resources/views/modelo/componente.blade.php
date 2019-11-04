<div id="formModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <form method="POST" id="componente_form" name="componente_forms" class="form-horizontal"
                enctype="multipart/form-data" action="">

                <div class="modal-header">

                    <h4 class="modal-title"> TITULO</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="avisosModalComponente">
                        {{-- Se muestran los mensajes de los ingredientes --}}

                    </div>

                    <div class="container">
                        <div align="right">



                            <button type="submit" id="agregarComponente" name="agregarComponente"
                                class="btn  btn-success  btn-flat btn-sm">Agregar Componente
                            </button>
                        </div>
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group  justify-content-center">

                                    <label for="">Subir Imagen</label>
                                    <br>
                                    <input type="file" name="imagenComponente" id="imagenComponente" required>
                                    <div id="previewComponente" class="row justify-content-center">
                                        <img src="{{asset("/imagenes/compontentes/".$modelo->imagenPrincipal)??'' }}"
                                            alt="" height="200px" width="200px">
                                    </div>
                                </div>
                            </div>
                            <div class="col">

                                <div class="form-group  ">
                                    <label class="control-label">Nombre: </label>

                                    <input type="text" name="nombreComponente" id="nombreComponente" required
                                        placeholder="Ingrese un Nombre" class="form-control" value="" />
                                </div>
                            </div>

                        </div>
                        <hr>

                        <div class="row justify-content-center">
                            <h3>Componentes del modelo</h3>
                        </div>
                        <hr>
                        <div class="card-deck  " id="componentes">
                            @if (!$modelo->componentes->isEmpty())

                            @foreach ($modelo->componentes as $componente)
                            <div class="form-group">


                                <div class="card" style="width: 15rem;">
                                    <img src="{{asset("/imagenes/componentes/".$componente->imagenPrincipal)??'' }}"
                                        class="card-img-top" alt="...">
                                    <div class="card-body ">
                                        <h4 class="text-center">{{$componente->nombre}}</h4>

                                    </div>
                                    <div class="card-footer text-center">


                                        <button type="button" name="deleteComponente" id="{{$componente->id}}"
                                            class="deleteComponente btn btn-outline-danger btn-sm">Quitar</button>


                                    </div>
                                </div>

                            </div>

                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-around">

                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>

                    <input type="hidden" name="hidden_id_modelo_componente" id="hidden_id_modelo_componente"
                        value="{{$modelo->id??''}}" />

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
                <h4 align="center" style="margin:0;">¿Esta seguro que desea quitarlo?</h4>
            </div>
            <div class="modal-footer">
                <form id="formDelete" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    {{-- Paso el id de la materia  aborrar en receta_delete--}}
                    <input type="hidden" name="receta_delete" id="receta_delete">
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>