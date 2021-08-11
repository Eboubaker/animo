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
        $wallpapers = Wallpaper::withCount('favorites')
            ->orderByDesc('favorites_count')
            ->orderByDesc('created_at');
        if(!empty(request('search')))
        {
            if(request('filter') === 'tag')
            {
                $wallpapers = $wallpapers->whereHas('tags', function($query){
                    $query->where('name', 'like', "%".request('search')."%");
                });
            }else{
                $wallpapers = $wallpapers->where('name', 'like', "%".request('search')."%");
            }
        }
        $wallpapers = $wallpapers->paginate(5*config('app.imagePerColumn'));
        return view('home', compact('wallpapers'));
    }
}
