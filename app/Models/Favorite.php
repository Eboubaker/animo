<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Favorite extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function wallpaper()
    {
        return $this->belongsTo(Wallpaper::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
