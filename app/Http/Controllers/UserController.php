<?php

namespace App\Http\Controllers;

use App\Calle;
use App\Direccion;
use App\DireccionEnvio;
use App\Documento;
use App\Localidad;
use App\Pais;
use App\Provincia;
use Illuminate\Http\Request;
use App\User;
use Caffeinated\Shinobi\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        if (!(auth()->user()->hasRole('admin')) && !(auth()->user()->hasRole('gerente'))) {

            # code...

            $admin = Role::where('name', 'admin')->first();
            $gerente = Role::where('name', 'gerente')->first();
            $auditor = Role::where('name', 'auditor')->first();
            $aux = collect();
            foreach ($usuarios as $usuario) {
                # code...
                if (!$usuario->hasRole('admin') && !$usuario->hasRole('gerente') && !$usuario->hasRole('auditor')) {
                    $aux->add($usuario);
                }
            }
            $usuarios = $aux;
            $roles = Role::all()
                ->where('id', '<>', $admin->id)
                ->where('id', '<>', $auditor->id)
                ->where('id', '<>', $gerente->id);
        } else {
            $roles = Role::all();
        }



        $documentos = Documento::all();

        return view('usuarios.index', compact('usuarios', 'documentos', 'roles'));
    }

    public function editMiPerfil()
    {

        $documentos = Documento::all();
        $paises = Pais::all();
        $provincias = Provincia::all();
        $localidades = Localidad::all();
        $calles = Calle::all();
        $usuario = User::find(auth()->user()->id);
        return view('usuarios.editMiPerfil', compact('documentos', 'paises', 'provincias', 'localidades', 'calles', 'usuario'));
    }
    public function modificar(Request $request)
    {

        $usuario = User::find(auth()->user()->id);
        $rules = [
            'nombre' => 'required|max: 50',
            'apellido' => 'required',
            'email' => 'required',
            'numeroDocumento' => 'required|max: 70',

            'documento_id' => 'required'

        ];
        $messages = [
            'nombre.required' => 'Nombre requerido',
            'nombre.max' => 'Max 50 caracteres',
            'numeroDocumento.required' => 'Numero de documento requerido',
            'numeroDocumento.max' => 'Max 70 caracteres',
            'apellido.required' => 'Apellido requerido',

            'email.unique' => 'Email debe ser unico',
            'email.required' => 'Email es requerido',


        ];
        if ($request->hasFile('imagenPrincipal')) {
            $rules = array_merge($rules, ['imagenPrincipal'     =>  'mimes:jpeg,png,jpg,gif,svg|max:2048']);
            $messages = array_merge($messages, [
                'imagenPrincipal.required'     => 'La imagen es obligatoria',
                'imagenPrincipal.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
                'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048'
            ]);
        }

        $this->validate($request, $rules, $messages);
        $existe = User::where('email', $request->email)->where('id', '<>', $usuario->id)->first();
        if ($existe != null) {
            return redirect()->back()->withErrors('email', 'El email ya existe');
        }
        $imagen = null;
        if ($request->hasFile('imagenPrincipal')) {
            $file = $request->file('imagenPrincipal');
            $hoy = Carbon::now();
            $imagen =  $usuario->id . $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();

            $file->move(public_path('/imagenes/usuarios/'), $imagen);

            $form_data = array(
                'name' => $request->nombre,
                'imagenPrincipal'        =>  $imagen,

                'apellido' => $request->apellido,
                'email' => $request->email,
                'numeroDocumento' => $request->numeroDocumento,
                'documento_id' => $request->documento_id
            );
            //creamos el camino de la imagen vieja
            if (!is_null($usuario->imagenPrincipal)) {

                $file_path = public_path() . '/imagenes/usuarios/' . $usuario->imagenPrincipal;
                //borramos la imagen vieja
                if (file_exists($file_path)) {
                    //borramos la imagen vieja
                    unlink($file_path);
                }
            }
        } else {
            $form_data = array(
                'name' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'numeroDocumento' => $request->numeroDocumento,
                'documento_id' => $request->documento_id
            );
        }
        // $usuario->fill($request->all());
        $usuario->update($form_data);
        return redirect()->back()->with('success', 'Datos modificados con exitos!');
        return redirect('/usuarios');
    }

    public function crearDireccion(Request $request)
    {


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
        $predert = 0;
        if (auth()->user()->direccionEnvios->isEmpty()) {
            $predert = 1;
        }
        $direccion = DireccionEnvio::create([
            'predeterminado'    =>  $predert,
            'user_id'    =>  auth()->user()->id,
            'direccion_id'    =>  $direccion->id
        ]);
        return redirect()->back()->with('success', 'Direccion creada con exito!');
    }
    public function direccionEnvioPredeterminada($id)
    {
        $direccionEnv = DireccionEnvio::find($id);
        if (is_null($direccionEnv) || ($direccionEnv->user->id != auth()->user()->id)) {
            return redirect()->back()->withErrors('No existe la direccion');
        }
        foreach (auth()->user()->direccionEnvios as $key => $direcc) {
            $direcc->predeterminado = 0;
            $direcc->update();
        }
        $direccionEnv->predeterminado = 1;
        $direccionEnv->update();
        return redirect()->back()->with('success', 'Direccion seleccionada con exito!');
    }

    public function cambiarPassword(Request $request)
    {
        # code...


        if (($request->passNuevo == '') || (is_null($request->passNuevo))) {
            return redirect()->back()->withErrors('Las contraseñas no pueden ser vacias');
        }
        if ($request->passConfirmacion == $request->passNuevo) {
            $usuario = User::find(auth()->user()->id);
            $pass = Hash::make($request->input('passNuevo'));
            $usuario->password = $pass;
            $usuario->update();
            return redirect()->back()->with('success', 'Se cambio la contraseña correctamente');
        }
        return redirect()->back()->withErrors('No coinciden las contraseña ingresadas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = new User();
        return view('usuarios.create', compact('usuario'));
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
            'apellido'    =>  'required',
            'email' => 'required|unique:users,email,NULL,deleted_at',
            'documento_id'    =>  'required|exists:documentos,id',
            'rol_id'    =>  'required|exists:roles,id',
            'numeroDocumento'    =>  'required'

        ];

        $messages = [
            'nombre.required'    =>  'Nombre requerido',
            'apellido.required'    =>  'Apellido requerido',
            'email.required'    =>  'Email requerido',
            'email.unique'    =>  'Ya se encuentra registrado',

            'documento_id.required'    =>  'El documento es requerido',
            'documento_id.exists'    =>  'El documento es no existe',

            'rol_id.required'    =>  'El rol es requerido',
            'rol_id.exists'    =>  'El rol  no existe',

            'numeroDocumento'    =>  'El numero de documento es requerido'
        ];

        $this->validate($request, $rules, $messages);
        $correo = User::where('email', $request->email)->first();
        if ($correo != null) {
            return redirect()->back()->withErrors('email', 'Ya existe un usuario con el correo');
        }

        $form_data = array(
            'name'        =>  $request->nombre,
            'apellido'    =>  $request->apellido,
            'email'    =>  $request->email,
            'documento_id'    =>  $request->documento_id,
            // 'rol_id'    =>  $request->rol_id,
            'numeroDocumento'    =>  $request->numeroDocumento,
            'password' => Hash::make('12345678')
        );
        $usuario = User::create($form_data);
        # code...
        $usuario->roles()->sync($request->rol_id);

        // $usuario->assignRoles($request->rol_id);


        return redirect()->back()->with('success', 'Usuario creado con exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = User::findOrFail($id);
            $admin = Role::where('name', 'admin')->first();
            $gerente = Role::where('name', 'gerente')->first();
            $auditor = Role::where('name', 'auditor')->first();
            if (!(auth()->user()->hasRole('admin')) && !(auth()->user()->hasRole('gerente'))) {

                $totalRoles = Role::where('id', '<>', $admin->id)
                    ->where('id', '<>', $auditor->id)
                    ->where('id', '<>', $gerente->id)
                    ->get();
            } else {

                $totalRoles = Role::all();
            }
            return response()->json([
                'data' => $data, 'totalRoles' => $totalRoles,
                'roles' => $data->roles, 'totalDocumentos' => Documento::all()

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'email'    =>  'required|unique:users,email,' . $request->hidden_id,

        ];

        $messages = [
            'nombre.required'    =>  'Nombre requerido',
            'apellido.required'    =>  'Apellido requerido',
            'email.required'    =>  'Email requerido',
            'email.unique'    =>  'Ya se encuentra registrado',

            'documento_id.required'    =>  'El documento es requerido',
            'documento_id.exists'    =>  'El documento es no existe',

            'rol_id.required'    =>  'El rol es requerido',
            'rol_id.exists'    =>  'El rol  no existe',

            'numeroDocumento'    =>  'El numero de documento es requerido'
        ];

        $this->validate($request, $rules, $messages);
        $correo = User::where('email', $request->email)->first();
        if ($correo != null) {
            return redirect()->back()->withErrors('email', 'Ya existe un usuario con el correo');
        }

        $form_data = array(
            'name'        =>  $request->nombre,
            'apellido'    =>  $request->apellido,
            'email'    =>  $request->email,
            'documento_id'    =>  $request->documento_id,
            // 'rol_id'    =>  $request->rol_id,
            'numeroDocumento'    =>  $request->numeroDocumento,
            'password' => Hash::make('12345678')
        );
        $usuario = User::find($request->hidden_id);

        $usuario->update($form_data);

        # code...
        $usuario->roles()->sync($request->rol_id);

        // $usuario->roles()->sync($request->rol_id);
        // $usuario->assignRoles($request->rol_id);


        return redirect()->back()->with('success', 'Usuario Actualizado con exito!');

        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $usuario = User::find($request->button_delete);
        if (!is_null($usuario)) {
            if (!$usuario->pedidos->isEmpty()) {
                return redirect()->back()->withErrors('El usuario tiene pedidos asociados no se pudo eliminar');
            }
            if (!$usuario->productos->isEmpty()) {
                return redirect()->back()->withErrors('El usuario tiene productos asociados no se pudo eliminar');
            }
            if (!$usuario->movimientos->isEmpty()) {
                return redirect()->back()->withErrors('El usuario tiene movimientos asociados no se pudo eliminar');
            }
            $usuario->delete();
            return redirect()->back()->with('warning', 'Se elimino correctamente');
        }
        return redirect()->back()->with('warning', 'No existe el usuario');
    }
}
