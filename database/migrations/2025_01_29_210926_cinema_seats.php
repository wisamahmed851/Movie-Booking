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
        Schema::create('cinema_seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cinema_id');
            $table->unsignedBigInteger('cinema_seats_categories_id');
            $table->string('seat_number')->comment("Seat row + Seat number");
            $table->boolean('status')->default(1)->comment("1 for active 0 for inavtive"); // 1 for active, 0 for inactive
            $table->timestamps();

            $table->foreign('cinema_seats_categories_id')->references('id')->on('cinema_seats_categories')->onDelete('cascade');
            $table->foreign('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('cinema_seats');
    }
};
