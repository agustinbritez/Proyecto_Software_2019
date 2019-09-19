<?php

use App\Item;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('materiaPrimas',function(){
    return datatables()
    ->eloquent(App\MateriaPrima::query())
    ->addColumn('btn','materiaPrima.botones')
    ->rawColumns(['btn'])
    ->toJson();
});

Route::get('items',function(){
    return datatables()
    ->eloquent(App\Item::query())
    ->addColumn('btn','item.botones')
    ->rawColumns(['btn'])
    ->toJson();
});

// Route::get('categorias',function(){
//     return datatables()
//     ->eloquent(App\Categoria::query())
//     ->addColumn('accion','categoria.botones')
//     ->rawColumns(['accion'])
//     ->toJson();
// });