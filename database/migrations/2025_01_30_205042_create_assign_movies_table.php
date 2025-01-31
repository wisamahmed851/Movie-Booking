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
        Schema::create('assign_movies', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('movie_id'); // Foreign key for movies
            $table->unsignedBigInteger('cinema_id'); // Foreign key for cinemas
            $table->tinyInteger('status')->default(1)->comment("! for Active And 0 for InActive"); // 1 = Active, 0 = Inactive
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assign_movies');
    }
};
