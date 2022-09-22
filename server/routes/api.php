<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\CorreoAdminController;
use App\Events\UserCreated;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('getCategorias', [CategoriasController::class, 'getCategorias']);
Route::get('getCorreoAdministrador', [CorreoAdminController::class, 'getCorreoAdministrador']);
Route::put('cambiarCorreoAdministrador', [CorreoAdminController::class, 'cambiarCorreoAdministrador']);

Route::get('getUsuarios', [UsuariosController::class, 'getUsuarios']);
Route::get('getUsuario/{id}', [UsuariosController::class, 'getUsuario']);
Route::post('addUsuarios', [UsuariosController::class, 'addUsuarios']);
Route::put('updateUsuarios', [UsuariosController::class, 'updateUsuarios']);
Route::delete('deleteUsuarios/{id}', [UsuariosController::class, 'deleteUsuarios']);