<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Entidades\Respuesta;
use App\Entidades\Mensajes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    public function getCategorias(){
    	$categorias = Categorias::all();
    	$respuesta = new Respuesta;
    	$mensaje = new Mensajes;
    	if (count($categorias)>0) {
    		$respuesta->datos = $categorias;
    		$respuesta->error = false;
    	}else{
    		$respuesta->mensaje = $mensaje->vacio;
    		$respuesta->error = true;
    	}
    	return response()->json($respuesta);
    }
}
