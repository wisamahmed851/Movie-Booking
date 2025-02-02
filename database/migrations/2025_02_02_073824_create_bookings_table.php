<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key for users table
            $table->decimal('total_price', 8, 2); // Total price of the booking
            $table->date('booking_date'); // Date of the booking
            $table->unsignedBigInteger('assign_movies_details_id'); // Foreign key for assign_movies_details table
            $table->string('status')->default('pending'); // Booking status (e.g., pending, confirmed, cancelled)
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // deleted_at for soft deletes

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assign_movies_details_id')->references('id')->on('assign_movies_details')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
