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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->json('genre_ids'); // JSON array for genres
            $table->json('language_ids'); // JSON array for languages
            $table->unsignedBigInteger('cover_image_id'); // Foreign key for cover image
            $table->unsignedBigInteger('banner_image_id'); // Foreign key for banner image
            $table->unsignedBigInteger('slider_image_id'); // Foreign key for slider images
            $table->integer('status')->default(1)->comment('0 for Inactive, 1 for Active'); // Adding a status column
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('cover_image_id')->references('id')->on('movie_images')->onDelete('cascade');
            $table->foreign('banner_image_id')->references('id')->on('movie_images')->onDelete('cascade');
            $table->foreign('slider_image_id')->references('id')->on('movie_images')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
