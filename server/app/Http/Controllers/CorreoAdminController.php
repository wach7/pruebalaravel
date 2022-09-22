<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CorreoAdmin;
use App\Entidades\Respuesta;
use App\Entidades\Mensajes;

class CorreoAdminController extends Controller
{
    public function getCorreoAdministrador(){
    	$correo = CorreoAdmin::first();
        $respuesta = new Respuesta;
        if (!empty($correo)) {
            $respuesta->datos = $correo;
            $respuesta->error = false;
        }else{
            $respuesta->mensaje = "No hay un correo definido";
            $respuesta->error = true;
        }
    	return response()->json($respuesta);
    }

    public function cambiarCorreoAdministrador(Request $req){
    	$respuesta = new Respuesta;
    	$mensaje = new Mensajes;
        $correo = CorreoAdmin::first();
        if (!empty($correo)) {
            $correo = CorreoAdmin::find($correo->id);
            if (!empty($correo)) {
            	$correo->correo = $req->correo;
            	if ($correo->save()) {
    	    		$respuesta->mensaje = $mensaje->actualizado;
    	    		$respuesta->error = false;
    	    	}else{
    	    		$respuesta->mensaje = $mensaje->error;
    	    		$respuesta->error = true;
    	    	}
            }else{
                $respuesta->mensaje = $mensaje->error;
                $respuesta->error = true;
            }
        }else{
            $correo = new CorreoAdmin();
            $correo->correo = $req->correo;
            if ($correo->save()) {
                $respuesta->mensaje = $mensaje->guardado;
                $respuesta->error = false;
            }else{
                $respuesta->mensaje = $mensaje->error;
                $respuesta->error = true;
            }
        }
        return response()->json($respuesta);
    }

}
