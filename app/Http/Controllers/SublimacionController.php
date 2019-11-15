<?php

namespace App\Http\Controllers;

use App\Imagen;
use App\Sublimacion;
use App\TipoImagen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SublimacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sublimacion  $sublimacion
     * @return \Illuminate\Http\Response
     */
    public function show(Sublimacion $sublimacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sublimacion  $sublimacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Sublimacion $sublimacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sublimacion  $sublimacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if ($request->hasFile('imagen_new')) {
            $rules = [
                'nombre'    =>  'required',
                'imagen_new'     =>  'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg',
                'tipoImagen_id'     =>  'required|integer'

            ];



            $messages = [
                'nombre.required' => 'El nombre de la imagen es obligatoria para las imagenes del sistema.',

                'tipoImagen_id.required' => 'Debe seleccionar un tipo de imagen como minimo',
                'tipoImagen_id.integer' => 'La imagen seleccionada no existe',

                'imagen_new.required'     => 'La imagen es obligatoria',
                'imagen_new.mimes'     => 'La extension de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
                'imagen_new.max'     => 'La resolucion maxima de la imagen es 2048',
            ];
        } else {
            if ($request->hasFile('imagen_sinProcesar')) {
                $rules = [

                    'imagen_sinProcesar'     =>  'required|mimes:jpeg,png,jpg,gif,svg|max:2048'

                ];



                $messages = [
                    'imagen_sinProcesar.required'     => 'La imagen es obligatoria es obligatoria',
                    'imagen_sinProcesar.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
                    'imagen_sinProcesar.max'     => 'La resolucion maxima de la imagen es 2048',
                ];
            }
        }

        $this->validate($request, $rules, $messages);

        //si el id que crea es uno borrado lo revivimos
        $sublimacion = Sublimacion::find($id);
        $tipoImagen = TipoImagen::find($request->tipoImagen_id);
        $imagen = null;
        //si entra en el primer if el administrador esta cargando una nueva imagen al sistema
        if ($request->hasFile('imagen_new') && ($tipoImagen != null)) {
            $file = $request->file('imagen_new');
            $hoy = Carbon::now();
            $imagen = $sublimacion->id . $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagen_new')->getClientOriginalExtension();

            $file->move(public_path('/imagenes/sublimaciones/' . $tipoImagen->nombre . '/'), $imagen);

            $imagenNueva = Imagen::create([
                'nombre' => $request->nombre,
                'imagen' => $imagen,
                'tipoImagen_id' => $request->tipoImagen_id
            ]);
            if ($imagenNueva != null) {
                if ($sublimacion->nuevaImagen != null) {
                    //creamos el camino de la imagen vieja
                    $file_path = public_path() . '/imagenes/sublimaciones/sinProcesar/' . $sublimacion->nuevaImagen;
                    //borramos la imagen vieja
                    unlink($file_path);
                    $sublimacion->nuevaImagen = null;
                }
                $sublimacion->imagen_id = $imagenNueva->id;

                $sublimacion->update();
                return redirect()->back()->with('success', 'Actualizado Correctamente');
            }
        } else {
            //si es imagen_sinProcesar se subio una imagen nueva para que no sea procesada
            //si entra en el if hay que controlar que el usuario 
            if ($request->hasFile('imagen_sinProcesar')) {
                $file = $request->file('imagen_sinProcesar');
                $hoy = Carbon::now();
                $imagen = $sublimacion->id . $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagen_sinProcesar')->getClientOriginalExtension();
                if ($sublimacion->nuevaImagen != null) {
                    //creamos el camino de la imagen vieja
                    $file_path = public_path() . '/imagenes/sublimaciones/sinProcesar/' . $sublimacion->nuevaImagen;
                    if (file_exists($file_path)) {
                        //borramos la imagen vieja
                        unlink($file_path);
                    }
                }
                $file->move(public_path('/imagenes/sublimaciones/sinProcesar/'), $imagen);

                $sublimacion->nuevaImagen = $imagen;
                $sublimacion->update();
                return redirect()->back()->with('success', 'Actualizado Correctamente');
            }
        }
        return redirect()->back()->withErrors('No se actualizo la sublimacion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sublimacion  $sublimacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sublimacion $sublimacion)
    {
        //
    }
}
