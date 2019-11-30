<?php

namespace App\Http\Controllers;

use App\Calle;
use App\Direccion;
use App\Documento;
use App\Localidad;
use App\MateriaPrima;
use App\Medida;
use App\Pais;
use App\PropuestaMateriaPrima;
use App\Proveedor;
use App\Provincia;
use Illuminate\Http\Request;
use DataTables;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $proveedores = Proveedor::all();
        $documentos = Documento::all();
        $paises = Pais::all();
        $provincias = Provincia::all();
        $localidades = Localidad::all();
        $calles = Calle::all();
        return view('proveedor.index', compact('proveedores', 'documentos', 'paises', 'provincias', 'localidades', 'calles'));
    }

    public function consultarPrecios($id)
    {
        # code...
        $proveedor = Proveedor::find($id);
        $medidas = Medida::all();
        // if (is_null($proveedor)) {
        //     return redirect()->route('home')->withErrors('No Existe El proveedor Ingresado ');
        // }
        return view('proveedor.consulta', compact('proveedor', 'medidas'));
    }
    public function obtenerPrecios(Request $request, $id)
    {
        # code...
        $proveedor = Proveedor::find($id);
        if (is_null($proveedor)) {
            return redirect()->route('home')->withErrors('No Existe el proveedor pasado por parametros');
        }
        for ($i = 0; $i <= $request->input('cantidadMaterias'); $i++) {

            $materiaPrima = MateriaPrima::find($request->input('materia_' . $i));
            if (!is_null($materiaPrima)) {
                $propuesta = PropuestaMateriaPrima::where('materiaPrima_id', $materiaPrima->id)->where('proveedor_id', $id)->get()->first();
                if (!is_null($propuesta)) {
                    $propuesta->precioUnitario = $request->input('precioUnitario_materia_' . $materiaPrima->id);
                    $propuesta->detalle = $request->input('informacion_materia_' . $materiaPrima->id);
                    $propuesta->medida_id = $request->input('medida_id_materia_' . $materiaPrima->id);
                    $propuesta->update();
                }
                // $propuesta = PropuestaMateriaPrima::create([
                //     'precioUnitario' => $request->input('precioUnitario_materia_' . $materiaPrima->id),
                //     'detalle' => $request->input('precioUnitario_materia_' . $materiaPrima->id),
                //     'medida_id' => $request->input('medida_id_materia_' . $materiaPrima->id),
                //     'materiaPrima_id' => $materiaPrima->id,
                //     'proveedor_id' => $id,
                // ]);

            }
        }
        $medidas = Medida::all();
        return redirect()->route('proveedor.consultarPrecios', $id)->with('success', 'Se guardo con exito su respuestas');
        // return view('proveedor.consulta', compact('proveedor', 'medidas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->numeroDocumento = strtoupper($request->numeroDocumento);
        //obtengo la materias primas borradas si elnombre se repite la reuso
        $proveedorExistente = Proveedor::where('numeroDocumento', $request->numeroDocumento)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el numeroDocumento esta repetido en una proveedor eliminado
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($proveedorExistente != null) {
            // $proveedorExistente->restore();
            $request->hidden_id = $proveedorExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Proveedor Creado Con Exito!');
        }

        $rules = [
            'nombre'    =>  'required',
            'email'     =>  'required|unique:proveedors',
            'razonSocial'     =>  'required',
            'domicilio'     =>  'required|integer',
            'documento_id'     =>  'required',
            'numeroDocumento'     =>  'required|unique:proveedors',
            'calle_id'    =>  'required',
            'localidad_id'    =>  'required',
            'provincia_id'    =>  'required',
            'pais_id'    =>  'required',
        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del proveedor.',
            'email.required' => 'Agrega el email del proveedor.',
            'razonSocial.required' => 'Agrega la  razonSocial del proveedor.',

            'documento_id.required' => 'Debe seleccionar algun tipo de documento.',
            'numeroDocumento.required' => 'Debe agregar un numero de documento.',
            'numeroDocumento.unique' => 'El numero de documento del proveedor debe ser unico.',

            'domicilio.required' => 'Agregar el numero de la direccion',
            'domicilio.integer' => 'El domicilio debe ser un valor entero',
            'calle_id.required' => 'Agregar la calle de la direccion',
            'localidad_id.required' => 'Agregar la localidad de la direccion',
            'provincia_id.required' => 'Agregar la provincia de la direccion',
            'pais_id.required' => 'Agregar el pais de la direccion'
        ];

        $this->validate($request, $rules, $messages);

        $direccion = Direccion::where('numero', $request->domicilio)->where('calle_id', $request->calle_id)
            ->where('localidad_id', $request->localidad_id)
            ->where('provincia_id', $request->provincia_id)
            ->where('pais_id', $request->pais_id)->first();


        if ($direccion == null) {
            $direccion = Direccion::create([
                'numero'    =>  $request->domicilio,
                'calle_id'    =>  $request->calle_id,
                'localidad_id'    =>  $request->localidad_id,
                'provincia_id'    =>  $request->provincia_id,
                'pais_id'    =>  $request->pais_id
            ]);
        }


        $form_data = array(
            'nombre'        =>  $request->nombre,
            'email'         =>  $request->email,
            'razonSocial'         =>  $request->razonSocial,
            'numeroDocumento' => $request->numeroDocumento,
            'direccion_id' => $direccion->id,
            'documento_id' => $request->documento_id
        );
        //si no crea es porque hay agun atributo que no permite null que esta vacio
        $proveedor = Proveedor::create($form_data);
        // $proveedor->documentos()->sync($documento);
        // $proveedor->direcciones()->sync($direccion);
        // return response()->json(['success' => 'Materia Prima Guardada Con Exito.']);
        return redirect()->back()->with('success', 'Proveedor creado con exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Proveedor::findOrFail($id);
            $totalDocumento = Documento::all();
            $totalCalles = Calle::all();
            $totalLocalidades = Localidad::all();
            $totalProvincias = Provincia::all();
            $totalPaises = Pais::all();

            return response()->json([
                'data' => $data,
                'totalDocumento' => $totalDocumento,
                'totalCalles' => $totalCalles,
                'totalLocalidades' => $totalLocalidades,
                'totalProvincias' => $totalProvincias,
                'totalPaises' => $totalPaises,

                'documento' => $data->documento,
                'direccion' => $data->direccion,
                'calle' => $data->direccion->calle,
                'provincia' => $data->direccion->provincia,
                'pais' => $data->direccion->pais,
                'localidad' => $data->direccion->localidad,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        //    $rules = [
        //         'nombre'    =>  'required',
        //         'email'     =>  'required|unique:proveedors',
        //         'razonSocial'     =>  'required',
        //         'documento_id'     =>  'required',
        //         'numeroDocumento'     =>  'required|unique:proveedors,nombre,' . $request->hidden_id,
        //         'calle'    =>  'required',
        //         'numero'    =>  'required|integer',
        //         'codigoPostal'    =>  'required|integer',
        //         'localidad'    =>  'required',
        //         'provincia'    =>  'required',
        //         'pais'    =>  'required',
        //     ];
        $rules = [
            'nombre'    =>  'required',
            'email'     =>  'required|unique:proveedors,email,' . $request->hidden_id,
            'razonSocial'     =>  'required',
            'domicilio'     =>  'required|integer',
            'documento_id'     =>  'required',
            'numeroDocumento'     =>  'required|unique:proveedors,nombre,' . $request->hidden_id,
            'calle_id'    =>  'required',
            'localidad_id'    =>  'required',
            'provincia_id'    =>  'required',
            'pais_id'    =>  'required',
        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del proveedor.',
            'email.required' => 'Agrega el email del proveedor.',
            'razonSocial.required' => 'Agrega la  razonSocial del proveedor.',

            'documento_id.required' => 'Debe seleccionar algun tipo de documento.',
            'numeroDocumento.required' => 'Debe agregar un numero de documento.',
            'numeroDocumento.unique' => 'El numero de documento del proveedor debe ser unico.',

            'domicilio.required' => 'Agregar el numero de la direccion',
            'domicilio.integer' => 'El domicilio debe ser un valor entero',
            'calle_id.required' => 'Agregar la calle de la direccion',
            'localidad_id.required' => 'Agregar la localidad de la direccion',
            'provincia_id.required' => 'Agregar la provincia de la direccion',
            'pais_id.required' => 'Agregar el pais de la direccion'
        ];
        // $messages = [
        //     'nombre.required' => 'Agrega el nombre del proveedor.',
        //     'email.required' => 'Agrega el email del proveedor.',
        //     'razonSocial.required' => 'Agrega la  razonSocial del proveedor.',

        //     'documento_id.required' => 'Debe seleccionar algun tipo de documento.',
        //     'numeroDocumento.required' => 'Debe agregar un numero de documento.',
        //     'numeroDocumento.unique' => 'El numero de documento del proveedor debe ser unico.',

        //     'calle.required' => 'Agregar la calle de la direccion',
        //     'numero.required' => 'Agregar el numero de la direccion',
        //     'numero.integer' => 'El numero debe ser un valor entero',
        //     'codigoPostal.required' => 'Agregar el codigo postal de la direccion',
        //     'codigoPostal.integer' => 'El codigo postal debe ser un valor entero',
        //     'localidad.required' => 'Agregar la localidad de la direccion',
        //     'provincia.required' => 'Agregar la provincia de la direccion',
        //     'pais.required' => 'Agregar el pais de la direccion'
        // ];


        $this->validate($request, $rules, $messages);
        $direccion = Direccion::where('numero', $request->domicilio)->where('calle_id', $request->calle_id)
            ->where('localidad_id', $request->localidad_id)
            ->where('provincia_id', $request->provincia_id)
            ->where('pais_id', $request->pais_id)->first();


        if ($direccion == null) {
            $direccion = Direccion::create([
                'numero'    =>  $request->domicilio,
                'calle_id'    =>  $request->calle_id,
                'localidad_id'    =>  $request->localidad_id,
                'provincia_id'    =>  $request->provincia_id,
                'pais_id'    =>  $request->pais_id
            ]);
        }
        $proveedor = Proveedor::find($request->hidden_id);
        $form_data = array(
            'nombre'        =>  $request->nombre,
            'email'         =>  $request->email,
            'razonSocial'         =>  $request->razonSocial,
            'numeroDocumento' => $request->numeroDocumento,
            'direccion_id' => $direccion->id,
            'documento_id' => $request->documento_id
        );
        $proveedor->update($form_data);
        // $proveedor->documentos()->sync($documento);
        // $proveedor->direcciones()->sync($direccion);
        // return response()->json(['success' => 'Materia Prima Guardada Con Exito.']);
        return redirect()->back()->with('success', 'Proveedor actualizado con exito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $proveedor = Proveedor::find($request->button_delete);
        $proveedor->delete();
        return redirect()->back()->with('success', 'Proveedor eliminado exitosamente');
    }
}
