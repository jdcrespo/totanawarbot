<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Usuario;

class UsuariosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function valida($idUsuario){
        $usuario = Usuario::where("twitter_user_id", $idUsuario)->first();
        if($usuario){
            $usuario->validado_por = Auth::user()->name;
            $usuario->validado = 1;
            if($usuario->save()){
                return redirect('/home')->with('status', 'Usuario validado correctamente.');
            }
        }
        return redirect('/home')->with('error', 'Error al validar el usuario.');
    }
}
