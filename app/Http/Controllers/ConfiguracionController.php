<?php

namespace App\Http\Controllers;

use App\Calle;
use App\Configuracion;
use App\Direccion;
use App\Localidad;
use App\Pais;
use App\Provincia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configuraciones = Configuracion::all();
        $paises = Pais::all();
        $provincias = Provincia::all();
        $localidades = Localidad::all();
        $calles = Calle::all();
        return view('configuraciones.index', compact('configuraciones', 'paises', 'provincias', 'localidades', 'calles'));
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


        $request->nombre = strtoupper($request->nombre);
        //obtengo la tipos movimientos borradas si elnombre se repite la reuso
        $configuracionExistente = Configuracion::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($configuracionExistente != null) {
            $request->hidden_id = $configuracionExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Configuracion Creada Con Exito!');
        }
        $rules = [
            'nombre'    =>  'required|unique:configuracions',
            'telefono' => 'required',
            'email'    =>  'required',
            'calle_id'    =>  'required',
            'localidad_id'    =>  'required',
            'provincia_id'    =>  'required',
            'domicilio'    =>  'required',
            'pais_id'    =>  'required',
            'imagenPrincipal'     =>  'required|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre de la empresa.',
            'nombre.unique' => 'El nombre debe ser unico.',
            'telefono.required' => 'Agrega el telefono.',
            'email.required' => 'Agrega el email.',
            'calle_id.required' => 'Seleccione una calle.',
            'localidad_id.required' => 'Seleccione una localidad.',
            'provincia_id.required' => 'Seleccione una localidad.',
            'domicilio.required' => 'Seleccione una localidad.',
            'pais_id.required' => 'Seleccione una localidad.',
            'imagenPrincipal.required'     => 'La imagen es obligatoria',
            'imagenPrincipal.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
            'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048'
        ];

        $this->validate($request, $rules, $messages);
        $imagen = null;
        if ($request->hasFile('imagenPrincipal') && $request->has('imagenPrincipal')) {
            $file = $request->file('imagenPrincipal');
            $hoy = Carbon::now();
            $imagen =  $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
            $file->move(public_path('/imagenes/configuraciones/'), $imagen);
        }
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
        $seleccionado = 0;
        if ($request->has('seleccionado')) {
            $seleccionado = 1;
            $configuraciones = Configuracion::all();
            foreach ($configuraciones as $configur) {
                # code...
                $configur->seleccionado = 0;
                $configur->update();
            }
        }
        $form_data = array(
            'nombre'        =>  $request->nombre,
            'telefono' => $request->telefono,
            'contacto' => $request->contacto,
            'email'    =>  $request->email,
            'direccion_id'    =>  $direccion->id,
            'imagenPrincipal'     =>  $imagen,
            'seleccionado'     =>  $seleccionado,
        );
        $configuracion = Configuracion::create($form_data);

        return redirect()->back()->with('success', 'Configuracion creado con exito!')->with('returnModal', 'mostrar modal');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Configuracion  $configuracion
     * @return \Illuminate\Http\Response
     */
    public function show(Configuracion $configuracion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Configuracion  $configuracion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Configuracion::findOrFail($id);
            return response()->json([
                'data' => $data,
                'direccion' => $data->direccion
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Configuracion  $configuracion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'nombre'    =>  'required|unique:configuracions,nombre,' . $request->hidden_id,
            'telefono' => 'required',
            'email'    =>  'required',
            'calle_id'    =>  'required',
            'localidad_id'    =>  'required',
            'provincia_id'    =>  'required',
            'domicilio'    =>  'required',
            'pais_id'    =>  'required',
            'imagenPrincipal'     =>  'mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre de la empresa.',
            'nombre.unique' => 'El nombre debe ser unico.',
            'telefono.required' => 'Agrega el telefono.',
            'email.required' => 'Agrega el email.',
            'calle_id.required' => 'Seleccione una calle.',
            'localidad_id.required' => 'Seleccione una localidad.',
            'provincia_id.required' => 'Seleccione una localidad.',
            'domicilio.required' => 'Seleccione una localidad.',
            'pais_id.required' => 'Seleccione una localidad.',
            'imagenPrincipal.required'     => 'La imagen es obligatoria',
            'imagenPrincipal.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
            'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048'
        ];

        $this->validate($request, $rules, $messages);

        $imagen = null;
        $configuracion = Configuracion::withTrashed()->find($request->hidden_id);
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


        $seleccionado = 0;
        if ($request->has('seleccionado')) {
            if (!$configuracion->seleccionado) {
                $seleccionado = 1;
                $configuraciones = Configuracion::all();
                foreach ($configuraciones as $configur) {
                    # code...
                    $configur->seleccionado = 0;
                    $configur->update();
                }
            }
            $configuracion = Configuracion::withTrashed()->find($request->hidden_id);
        } else {
            if ($configuracion->seleccionado) {
                $seleccionado = 1;
            }
        }
        if ($request->hasFile('imagenPrincipal') && $request->has('imagenPrincipal')) {
            $file = $request->file('imagenPrincipal');
            $hoy = Carbon::now();
            $imagen =  $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
            $file->move(public_path('/imagenes/configuraciones/'), $imagen);

            //creamos el camino de la imagen vieja
            if (!is_null($configuracion->imagenPrincipal)) {

                $file_path = public_path() . '/imagenes/configuraciones/' . $configuracion->imagenPrincipal;
                if (file_exists($file_path)) {
                    //borramos la imagen vieja
                    unlink($file_path);
                }
            }
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'telefono' => $request->telefono,
                'contacto' => $request->contacto,
                'email'    =>  $request->email,
                'direccion_id'    =>  $direccion->id,
                'imagenPrincipal'     =>  $imagen,
                'seleccionado'     =>  $seleccionado,
            );
        } else {
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'telefono' => $request->telefono,
                'contacto' => $request->contacto,
                'email'    =>  $request->email,
                'direccion_id'    =>  $direccion->id,
                'seleccionado'     =>  $seleccionado,
            );
        }



        $configuracion->restore();
        $configuracion->update($form_data);


        return redirect()->back()->with('success', 'Actualizado correctamente')->with('returnModal', 'mostrar modal');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Configuracion  $configuracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $configuracion = Configuracion::find($request->button_delete);
        if (!is_null($configuracion)) {

            if ($configuracion->seleccionado) {
                return redirect()->back()->withErrors('No se puee eliminar la configuracion usada o seleccionada');
            }

            $configuracion->delete();
        }
        return redirect()->back()->with('warning', 'No existe la configuracion');
    }
}
