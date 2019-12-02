@extends('admin_panel.index')


@section('content')



<br>

<div class="container">

    <div class="row">
        <div class="col">
            <div class="card text-left">

                <div class="card-header">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                    <h3>Informacion Proveedor</h3>
                </div>


                <div class="card-body">

                    <div class="row">
                        <h4><label for="">Proveedor:
                                {{$propuesta->proveedor->nombre}}</label></h4>
                    </div>
                    <div class="row">
                        <h4>

                            <label style="font-weight: normal;" for="">Correo: {{$propuesta->proveedor->email}}</label>
                        </h4>
                    </div>
                    <div class="row">
                        <h4>

                            <label style="font-weight: normal;" for="">Direccion:
                                {{$propuesta->proveedor->direccion->pais->nombre.' - '.$propuesta->proveedor->direccion->provincia->nombre.' - '.$propuesta->proveedor->direccion->localidad->nombre.' - '.$propuesta->proveedor->direccion->calle->nombre.' - ('.$propuesta->proveedor->direccion->numero.')'}}</label>
                        </h4>
                    </div>
                    <div class="row">
                        <h4>

                            <label style="font-weight: normal;" for="">
                                {{$propuesta->proveedor->documento->nombre .': '.$propuesta->proveedor->numeroDocumento}}</label>
                        </h4>
                    </div>
                    <hr>
                    <h3>Propuesta para stock minimo</h3>

                    <div class="table-responsive ">
                        <table class='table table-bordered table-striped table-hover datatable' id='data-table'>
                            <thead style="background-color:white ; color:black;">
                                <tr class="text-center">
                                    <th colspan="6">
                                        {{$propuesta->materiaPrima->nombre . ' (ID: '.$propuesta->materiaPrima->id.')'  }}
                                    </th>
                                </tr>
                                <tr>

                                    <th>Precio Actual</th>
                                    <th>Precio Propuesto</th>

                                    <th>Unidad Medida Actual</th>
                                    <th>Unidad Medida Propuesto</th>
                                    <th>Stock Actual</th>
                                    <th>Stock Minimo</th>

                                </tr>
                            </thead>
                            <tbody style="background-color:white ; color:black;">
                                <tr class="text-right">
                                    <td>
                                        <p for="" data-mask
                                            {{-- data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false"> --}}
                                            data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,
										'digitsOptional': false, 'placeholder': '0'">
                                            {{$propuesta->materiaPrima->precioUnitario}}
                                        </p>

                                    </td>
                                    <td>
                                        <p for="" data-mask
                                            {{-- data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false"> --}}
                                            data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,
										'digitsOptional': false, 'placeholder': '0'">
                                            {{$propuesta->precioUnitario}}
                                        </p>

                                    </td>
                                    <td class="text-left">
                                        {{$propuesta->materiaPrima->medida->nombre}}
                                    </td>
                                    <td class="text-left">
                                        @if (!is_null($propuesta->medida))

                                        {{$propuesta->medida->nombre}}
                                        @endif
                                    </td>
                                    <td>

                                        <p for="" data-mask
                                            {{-- data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false"> --}}
                                            data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0,
                                    'digitsOptional': false, 'placeholder': '0'">
                                            {{$propuesta->materiaPrima->cantidad}}
                                        </p>
                                    </td>
                                    <td>

                                        <p for="" data-mask
                                            {{-- data-inputmask="'alias': 'numeric',  'digits': 0, 'digitsOptional': false"> --}}
                                            data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0,
                                    'digitsOptional': false, 'placeholder': '0'">
                                            {{$propuesta->materiaPrima->stockMinimo}}
                                        </p>

                                    </td>
                                </tr>
                            </tbody>


                        </table>
                    </div>

                </div>
                <div class="card-footer text-muted">
                    <div class="text-center">

                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

@endsection



@section('htmlFinal')
@endsection