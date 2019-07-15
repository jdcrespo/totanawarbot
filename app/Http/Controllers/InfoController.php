<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Usuario;
use App\Models\TipoTweet;

class InfoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth','verified']);
    }

    public function index(){
        $muertos = Usuario::where("vivo", 0)->where("validado", 1)->get();
        $vivos = Usuario::where("vivo", 1)->where("validado", 1)->get();
        $tiposTweet = TipoTweet::all();
        return view('/info', compact(["muertos", "vivos", "tiposTweet"]));
    }
}
