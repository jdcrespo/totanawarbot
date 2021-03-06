<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoTweet;

class TipoTweetController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposTweet = TipoTweet::all();
        return view("tipoTweet/list", compact("tiposTweet"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("tipoTweet.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'contenido' => 'required|max:240',
        ]);

        $victimas = substr_count($request->contenido, "@[VICTIMA]");
        $asesinos = substr_count($request->contenido, "@[ASESINO]");
        if($victimas <= 0){
            return back()->withInput()->withErrors(['contenido', 'Debe haber al menos una víctima']);
        }

        $tipoTweet = new TipoTweet([
                        "contenido" => $request->contenido,
                        "victimas" => $victimas,
                        "asesinos" => $asesinos,
        ]);
        if($tipoTweet->save()){
            return redirect()->route("tipoTweet.index")->with('guardado', 'Plantilla añadida correctamente');
        }else{
            return back()->withInput()->withErrors(['guardado', 'Error al guardar']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoTweet = TipoTweet::findOrFail($id);
        return view("tipoTweet.show", compact('tipoTweet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoTweet = TipoTweet::findOrFail($id);
        return view("tipoTweet.show", compact('tipoTweet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipoTweet = TipoTweet::findOrFail($id);
        
        $validatedData = $request->validate([
            'contenido' => 'required|max:240',
        ]);

        $victimas = substr_count($request->contenido, "@[VICTIMA]");
        $asesinos = substr_count($request->contenido, "@[ASESINO]");
        if($victimas <= 0){
            return back()->withInput()->withErrors(['contenido', 'Debe haber al menos una víctima']);
        }
        $tipoTweet->contenido = $request->contenido;
        $tipoTweet->victimas = $victimas;
        $tipoTweet->asesinos = $asesinos;
        $tipoTweet->update();
        
        return redirect()->route("tipoTweet.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoTweet = TipoTweet::findOrFail($id)->delete();
        return redirect()->route("tipoTweet.index");
    }
}
