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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id'); // Foreign key for bookings table
            $table->unsignedBigInteger('seat_id'); // Foreign key for cinema_seats table
            $table->unsignedBigInteger('cinema_seats_categories_id'); // Foreign key for cinema_seats table
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // deleted_at for soft deletes

            // Foreign key constraints
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('seat_id')->references('id')->on('cinema_seats')->onDelete('cascade');
            $table->foreign('cinema_seats_categories_id')->references('id')->on('cinema_seats_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_details');
    }
};
