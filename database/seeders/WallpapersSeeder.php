<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use App\Models\Wallpaper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WallpapersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directory = storage_path("faker/images");
        $images = array_diff(scandir($directory), array('..', '.'));
        $tag = Tag::create(["name" => "mix"]);
        User::create(["username" => "abdoo", "password" => Hash::make("abdoo")]);
        foreach($images as $image)
        {
            $image = $directory . DIRECTORY_SEPARATOR . $image;
            $meta = getimagesize($image);
            $mime = $meta["mime"];
            $width = $meta[0];
            $height = $meta[1];
            $name = basename($image);
            $uploader_id = 1;
            $size = filesize($image);
            $wallpaper = $tag->wallpapers()->create(compact('width', 'height', 'mime', 'name', 'uploader_id', 'size'));
            $wallpaper->getFileFrom($image);
        }
    }
}
