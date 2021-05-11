<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Tag;
use App\Models\User;
use App\Models\Wallpaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;

class WallpaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'images' => 'required',
            'images.*' => 'mimes:jpg,jpeg,png'
        ], [], [
            "images" => "image",
            "images.*" => "image"
        ]);
        $tag = Tag::first();
        try {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->path();
                Log::info($imagePath);
                $meta = getimagesize($imagePath);
                if($meta === false)
                {
                    return back()->withErrors(new MessageBag(["images" => "can't open image " + $image->getClientOriginalName()]));
                }
                $mime = $meta["mime"];
                $width = $meta[0];
                $height = $meta[1];
                $name = $image->getClientOriginalName();
                $uploader_id = 1;
                $size = filesize($image);
                $wallpaper = $tag->wallpapers()->create(compact('width', 'height', 'mime', 'name', 'uploader_id', 'size'));
                $wallpaper->getFileFrom($imagePath);
            }
        }catch(\Throwable $e)
        {
            dd($e);
            abort(500);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallpaper  $wallpaper
     * @return \Illuminate\Http\Response
     */
    public function show(Wallpaper $wallpaper)
    {
        return view('wallpaper.show', compact('wallpaper'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wallpaper  $wallpaper
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallpaper $wallpaper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallpaper  $wallpaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallpaper $wallpaper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallpaper  $wallpaper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallpaper $wallpaper)
    {
        //
    }


    public function validated(Request $request)
    {
        return $request->validate($this->rules());
    }
    public function rules()
    {
        return [

        ];
    }
}
