<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\ControllerSistema;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/ejemplo',[ControllerSistema::class,'ejemplo1']);
Route::get('/ejemplo2',[ControllerSistema::class,'ejemplo2']);

Route::get('/categoria',[ControllerSistema::class,'categoria']);
Route::post('/guardarNuevoCategoria',[ControllerSistema::class,'guardarNuevoCategoria']);
Route::post('/cambiarEstadoCat',[ControllerSistema::class,'cambiarEstadoCat']);
Route::post('/editarCategoria',[ControllerSistema::class,'editarCategoria']);
Route::post('/guardarEditarCategoria',[ControllerSistema::class,'guardarEditarCategoria']);

Route::get('/producto',[ControllerSistema::class,'producto']);
Route::post('/guardarNuevoProducto',[ControllerSistema::class,'guardarNuevoProducto']);
Route::post('/estadoProducto',[ControllerSistema::class,'estadoProducto']);
Route::post('/editarProducto',[ControllerSistema::class,'editarProducto']);

Route::post('/guardarEditarProducto',[ControllerSistema::class,'guardarEditarProducto']);

Route::get('/graficos',[ControllerSistema::class,'graficos']);
Route::post('/mostrarReporteGrafico',[ControllerSistema::class,'mostrarReporteGrafico']);

Route::get('/reporteProductoPdf',[ControllerSistema::class,'reporteProductoPdf']);
Route::get('/reporteProductoExcel',[ControllerSistema::class,'reporteProductoExcel']);
