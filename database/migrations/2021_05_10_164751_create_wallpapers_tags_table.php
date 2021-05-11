<?php

use App\Models\Tag;
use App\Models\Wallpaper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWallpapersTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallpapers_tags', function (Blueprint $table) {
            $table->foreignIdFor(Tag::class);
            $table->foreignIdFor(Wallpaper::class);
            $table->unique(['tag_id', 'wallpaper_id']);

            $table->foreign('tag_id')->on('tags')->references('id');
            $table->foreign('wallpaper_id')->on('wallpapers')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallpapers_tags');
    }
}
