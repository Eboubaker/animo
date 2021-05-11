<?php

namespace App\Http\Controllers;

use App\Models\Wallpaper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',[
            "wallpapers" => Wallpaper::withCount('favorites')->orderByDesc('favorites_count')->orderByDesc('created_at')->paginate(5*config('app.imagePerColumn'))
        ]);
    }
}
