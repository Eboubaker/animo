<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wallpaper extends Model
{
    use HasFactory;


    protected $guarded = [];
    private static $extensions = [
        "image/jpeg" => "jpg",
        "image/png" => "png"
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'wallpapers_tags')->withTimestamps();
    }
    public function getExtensionAttribute()
    {
        return self::$extensions[$this->attributes["mime"]];
    }
    public function getFullExtensionAttribute()
    {
        return ".".$this->extension;
    }
    public function getStoragePathAttribute()
    {
        return public_path("images") . DIRECTORY_SEPARATOR. $this->getKey() . $this->fullExtension;
    }
    public function getPathAttribute()
    {
        return url("images/".$this->getKey().$this->fullExtension);
    }
    public function getPreviewPathAttribute()
    {
        return url("images/".$this->previewFullName);
    }
    public function getPreviewFullNameAttribute()
    {
        return $this->getKey().".small.jpg";
    }
    public function getFileFrom($path)
    {
        $result = copy($path, public_path('images'). DIRECTORY_SEPARATOR . $this->getKey() . $this->fullExtension);
        if($result)
        {
            $percent = 0.5;
            $newwidth = $this->width * $percent;
            $newheight = $this->height * $percent;
            $reduced = imagecreatetruecolor($newwidth, $newheight);
            $source = null;
            if($this->extension == 'jpg')
            {
                $source = imagecreatefromjpeg($this->storagePath);
            }else if($this->extension == 'png')
            {
                $source = imagecreatefrompng($this->storagePath);
            }
            // Resize
            imagecopyresized($reduced, $source, 0, 0, 0, 0, $newwidth, $newheight, $this->width, $this->height);

            // Output
            imagejpeg($reduced, public_path('images') . DIRECTORY_SEPARATOR . $this->previewFullName);
        }
        return $result;
    }

    public function getIsFavoriteAttribute()
    {
        return Auth::user() && Auth::user()->favorites()->where('wallpaper_id', $this->getKey())->limit(1)->exists();
    }
}
