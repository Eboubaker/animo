<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Wallpaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class WallpaperController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update']);
    }
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
        $data = $request->all();
        $data['tags'] = array_filter(explode(',', $data['tags']), function($v){
            return !empty($v);
        });
        $validated = Validator::make($data, [
            'images' => 'required',
            'images.*' => 'mimes:jpg,jpeg,png',
            'tags' => 'required|array|min:1',
            'tags.*' => 'min:2'
        ], [
            'tags.min' => 'Please give at least 1 tag for the image',
            'tags.*.min' => 'each tag must 2 characters or longer'
        ], [
            "images" => "image",
            "images.*" => "image",
        ])->validate();

        $tags = [];
        foreach($validated['tags'] as $tag)
        {
            $tags[] = Tag::firstOrCreate(['name' => $tag]);
        }
        foreach ($request->file('images') as $image) {
            $imagePath = $image->path();
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
            $wallpaper = Wallpaper::make(compact('width', 'height', 'mime', 'name', 'uploader_id', 'size'));
            $wallpaper->save();
            $wallpaper->tags()->saveMany($tags);
            $wallpaper->getFileFrom($imagePath);
        }
        return redirect($wallpaper->url);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallpaper  $wallpaper
     * @return \Illuminate\Http\Response
     */
    public function show(Wallpaper $wallpaper)
    {
        App::terminating(function()use($wallpaper){
            $wallpaper->increment('view_count');
        });
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
