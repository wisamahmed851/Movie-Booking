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
        Schema::create('assign_movies_details', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('assign_movies_id'); // Foreign key for assign_movies
            $table->unsignedBigInteger('cinema_timings_id'); // Foreign key for cinema_timings
            $table->date('show_date'); // Date of the show
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('assign_movies_id')->references('id')->on('assign_movies')->onDelete('cascade');
            $table->foreign('cinema_timings_id')->references('id')->on('cinema_timings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assign_movies_details');
    }
};
