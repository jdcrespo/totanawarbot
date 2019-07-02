<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuarios = Usuario::orderBy('validado', 'asc')->get();
        $totalUsuarios = count($usuarios);
        $totalVerificados = count(Usuario::where('validado', 1)->get());
        return view('home', compact(["usuarios", "totalUsuarios", "totalVerificados"]));
    }
}
