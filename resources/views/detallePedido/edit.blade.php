<div id="editDetallePedido" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="editDetallePedido_form" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">

                    <h4 class="modal-title"> TITULO</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <label class="control-label">Detalle : </label>

                            <input type="text" class="form-control text-left" name="detalle" id="detalle">

                        </div>
                        <div class="col">
                            <label class="control-label">Cantidad : </label>

                            <input type="text" class="form-control text-left" name="cantidad" id="cantidad"
                                placeholder="Cantidad de materia prima inicial" data-mask
                                data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false">
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-around">
                    <input type="submit" name="action_button_direccion" id="action_button_direccion"
                        class="btn btn-success" value="Actualizar" />
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>
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
                <form id="formDelete" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    {{-- Paso el id de la materia  aborrar en materia_delete--}}
                    <input type="hidden" name="materia_delete" id="materia_delete">
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>