<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('movie_images', function (Blueprint $table) {
            $table->id();
            $table->string('cover_image_path')->nullable(); // Path for cover image
            $table->string('banner_image_path')->nullable(); // Path for banner image
            $table->json('slider_images')->nullable(); // Array of slider image paths
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_images');
    }
};
