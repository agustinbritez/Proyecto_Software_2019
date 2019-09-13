<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users= User::all();
        return view('usuarios.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario= new User();
        return view('usuarios.create',compact('usuario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //validacion de los campos de entrada
         $validateData = $request->validate([
            'nombre'=>'required|max: 50',
            'password'=>'required',
            'apellido'=>'required',
            'documento'=>'required',
            'email'=>'required'

        ]);

        $usuario = new User();
        //busca el inpunt con el nombre 'name' y guar su valor en el atributo 'name'
        $usuario->nombre= $request->input('nombre');
        $usuario->apellido=$request->input('apellido');
        $usuario->email=$request->input('email');
        $usuario->documento=$request->input('documento');
        $usuario->password=crypt($request->input('password'));
        //guarda en la base de datos
        $usuario->save();
        return redirect('/usuarios');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        return view('usuarios.show',compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        return view('usuarios.edit',compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $usuario->fill($request->all());
        $usuario->save();
        return redirect('/usuarios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario )
    {
        $usuario->delete();
        return redirect('/usuarios');
    }
}
