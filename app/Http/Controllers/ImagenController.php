<?php

namespace App\Http\Controllers;

use App\Imagen;
use App\TipoImagen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoImagenes = TipoImagen::all();

        $imagenes = Imagen::all();
        return view('imagen.index', compact('imagenes', 'tipoImagenes'));
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




        $rules = [
            'nombre'    =>  'required',
            'imagenPrincipal'     =>  'mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg',
            'tipoImagen_id'     =>  'required|integer'
        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre de la imagen.',

            'tipoImagen_id.required' => 'Debe seleccionar un tipo de imagen.',
            'tipoImagen_id.integer' => 'El tipo de imagen seleccionado no existe',


            'imagenPrincipal.required'     => 'La imagen es obligatoria',
            'imagenPrincipal.mimes'     => 'La imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
            'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048',
        ];

        $this->validate($request, $rules, $messages);
        $tipoImagen = TipoImagen::find($request->tipoImagen_id);

        if ($tipoImagen == null) {
            return redirect()->back()->withErrors('El tipo de imagen seleccionado no existe!');
        }



        if ($request->hasFile('imagenPrincipal')) {
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'imagen'        =>  null,
                'tipoImagen_id'         =>  $request->tipoImagen_id
            );

            $imagenObjeto = Imagen::create($form_data);
            if ($imagenObjeto == null) {
                return redirect()->back()->withErrors('No se pudo crear la imagen!');
            }
            $file = $request->file('imagenPrincipal');
            $hoy = Carbon::now();
            $imagen =  $imagenObjeto->id . $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();

            $file->move(public_path('/imagenes/sublimaciones/' . $tipoImagen->nombre), $imagen);
            $imagenObjeto->imagen = $imagen;
            $imagenObjeto->update();
            return redirect()->back()->with('success', 'Imagen Creada Con Exito!');
        }

        return redirect()->back()->withErrors('No se pudo crear la imagen!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function show(Imagen $imagen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Imagen::findOrFail($id);
            // if (is_null($data)) {
            //     return response()->json([
            //         'data' => $data, 'tipoImagen' => $data->tipoImagen,
            //         'totalTipoImagenes ' => TipoImagen::all()
            //     ]);
            // }
            return response()->json([
                'data' => $data, 'tipoImagen' => $data->tipoImagen,
                'totalTipoImagenes' => TipoImagen::all()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'nombre'    =>  'required',
            'imagenPrincipal'     =>  'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg',
            'tipoImagen_id'     =>  'required|integer'
        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre de la imagen.',

            'tipoImagen_id.required' => 'Debe seleccionar un tipo de imagen.',
            'tipoImagen_id.integer' => 'El tipo de imagen seleccionado no existe',


            'imagenPrincipal.required'     => 'La imagen es obligatoria',
            'imagenPrincipal.mimes'     => 'La imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
            'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048',
        ];

        $this->validate($request, $rules, $messages);

        //si el id que crea es uno borrado lo revivimos
        $imagenObjeto = Imagen::find($request->hidden_id);

        $tipoImagen = TipoImagen::find($request->tipoImagen_id);
        if ($imagenObjeto == null) {
            return redirect()->back()->withErrors('La imagen para actualizar no existe!');
        }
        if ($tipoImagen == null) {
            return redirect()->back()->withErrors('El tipo de imagen seleccionado no existe!');
        }



        if ($request->hasFile('imagenPrincipal')) {
            $file = $request->file('imagenPrincipal');
            $hoy = Carbon::now();
            $imagen = $imagenObjeto->id . $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
            $file->move(public_path('/imagenes/sublimaciones/' . $tipoImagen->nombre . '/'), $imagen);
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'imagen'        =>  $imagen,
                'tipoImagen_id'         =>  $request->tipoImagen_id
            );
            //creamos el camino de la imagen vieja
            $file_path = public_path() . '/imagenes/sublimaciones/' . $imagenObjeto->tipoImagen->nombre . '/' . $imagenObjeto->imagen;
            if (file_exists($file_path)) {
                //borramos la imagen vieja
                unlink($file_path);
            }
        } else {
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'tipoImagen_id'         =>  $request->tipoImagen_id
            );
        }




        $imagenObjeto->update($form_data);

        // return response()->json(['success' => 'Materia Prima Actualizada Correctamente']);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $imagen = Imagen::find($id);
        if ($imagen == null) {
            return redirect()->back()->withErrors(['message2' => 'La imagen a eliminar no existe']);
        }
        if (!$imagen->sublimaciones->isEmpty()) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar porque esta asociados a sublimaciones de productos']);
        }

        $imagen->delete();
        return redirect()->back()->with('warning', 'Se elimino la imagen de manera correcta');
    }
}
