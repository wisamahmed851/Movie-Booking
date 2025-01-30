<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('cinema_seats_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cinema_id');
            $table->unsignedBigInteger('seat_category_id');
            $table->string('seats_row');
            $table->integer('seat_number');
            $table->decimal('price', 8, 2); // Add this line
            $table->timestamps();

            $table->foreign('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
            $table->foreign('seat_category_id')->references('id')->on('seat_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('cinema_seats_details');
    }
};
