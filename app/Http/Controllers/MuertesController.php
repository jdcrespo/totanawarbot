<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MuerteTweet;


class MuertesController extends Controller
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
        $muertes = MuerteTweet::orderBy('created_at', 'desc')->get();
        return view('muertes', compact("muertes"));
    }
}
