<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Models\Categorias;
use App\Events\UserCreated;
use App\Entidades\Respuesta;
use App\Entidades\Mensajes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    public function getUsuarios(){
    	$usuarios = DB::table('usuarios as u')
                    ->join('categorias as c', 'u.categoria_id', 'c.id')->select('u.id', 'u.cedula', 'u.nombre', 'u.apellidos', 'u.email', 'u.direccion', 'u.celular', 'c.categoria')->get();
    	$respuesta = new Respuesta;
    	$mensaje = new Mensajes;
    	if (count($usuarios)>0) {
    		$respuesta->datos = $usuarios;
    		$respuesta->error = false;
    	}else{
    		$respuesta->mensaje = $mensaje->vacio;
    		$respuesta->error = true;
    	}
    	return response()->json($respuesta);
    }

    public function getUsuario($id){
    	$usuarios = Usuarios::find($id);
    	$respuesta = new Respuesta;
    	$mensaje = new Mensajes;
    	if (!empty($usuarios)) {
    		$respuesta->datos = $usuarios;
    		$respuesta->error = false;
    	}else{
    		$respuesta->mensaje = $mensaje->vacio;
    		$respuesta->error = true;
    	}
    	return response()->json($respuesta);
    }

    public function addUsuarios(Request $req){
    	$respuesta = new Respuesta;
    	$mensaje = new Mensajes;
        if ($this->verificar_cedula_crear($req->cedula)) {
            $respuesta->mensaje = "Ya existe un registro con este numero de documento";
            $respuesta->error = true;
            return response()->json($respuesta);
        }
    	if ($this->verificar_correo_crear($req->email)){
    		$respuesta->mensaje = "Este email ya esta en uso";
    		$respuesta->error = true;
    		return response()->json($respuesta);
    	}
    	$contacto = new Usuarios;
        $contacto->cedula = $req->cedula;
    	$contacto->nombre = $req->nombre;
    	$contacto->apellidos = $req->apellidos;
    	$contacto->direccion = $req->direccion;
        $contacto->celular = $req->celular;
    	$contacto->categoria_id = $req->categoria;
    	$contacto->email = $req->email;
    	if ($contacto->save()) {
            UserCreated::dispatch($req->email);
    		$respuesta->mensaje = $mensaje->guardado;
    		$respuesta->error = false;
    	}else{
    		$respuesta->mensaje = $mensaje->error;
    		$respuesta->error = true;
    	}
    	return response()->json($respuesta);
    }

    private function verificar_cedula_crear($cedula){
        $verificar_correo = Usuarios::where('cedula', $cedula)->first();
        if (!empty($verificar_correo)) {
            return true;
        }else{
            return false;
        }
    }

    private function verificar_correo_crear($correo){
    	$verificar_correo = Usuarios::where('email', $correo)->first();
    	if (!empty($verificar_correo)) {
    		return true;
    	}else{
    		return false;
    	}
    }

    public function updateUsuarios(Request $req){
    	$respuesta = new Respuesta;
    	$mensaje = new Mensajes;
        if ($this->verificar_cedula_actualizar($req->id, $req->cedula)) {
            $respuesta->mensaje = "Ya existe un registro con este numero de documento";
            $respuesta->error = true;
            return response()->json($respuesta);
        }
    	if ($this->verificar_correo_actualizar($req->id, $req->email)){
    		$respuesta->mensaje = "Este email ya esta en uso";
    		$respuesta->error = true;
    		return response()->json($respuesta);
    	}
    	$contacto = Usuarios::find($req->id);
    	if (!empty($contacto)) {
            $contacto->cedula = $req->cedula;
            $contacto->nombre = $req->nombre;
            $contacto->apellidos = $req->apellidos;
            $contacto->direccion = $req->direccion;
            $contacto->celular = $req->celular;
            $contacto->categoria_id = $req->categoria;
            $contacto->email = $req->email;
	    	if ($contacto->save()) {
	    		$respuesta->mensaje = $mensaje->actualizado;
	    		$respuesta->error = false;
	    	}else{
	    		$respuesta->mensaje = $mensaje->error;
	    		$respuesta->error = true;
	    	}
    	}
	    return response()->json($respuesta);
    }

    private function verificar_cedula_actualizar($id, $cedula){
        $verificar_correo = Usuarios::where('id', '<>', $id)->where('cedula', $cedula)->first();
        if (!empty($verificar_correo)) {
            return true;
        }else{
            return false;
        }
    }

    private function verificar_correo_actualizar($id, $correo){
    	$verificar_correo = Usuarios::where('id', '<>', $id)->where('email', $correo)->first();
    	if (!empty($verificar_correo)) {
    		return true;
    	}else{
    		return false;
    	}
    }

    public function deleteUsuarios($id){
    	$respuesta = new Respuesta;
    	$mensaje = new Mensajes;
    	$contacto = Usuarios::find($id);
    	if (!empty($contacto)) {
    		if ($contacto->delete()) {
	   			$respuesta->mensaje = $mensaje->borrado;
	    		$respuesta->error = false;
	    	}else{
	    		$respuesta->mensaje = $mensaje->error;
	    		$respuesta->error = true;
	    	} 
       	}else{
			$respuesta->mensaje = $mensaje->error;
	    	$respuesta->error = true;
    	}
    	return response()->json($respuesta);
    }
}
