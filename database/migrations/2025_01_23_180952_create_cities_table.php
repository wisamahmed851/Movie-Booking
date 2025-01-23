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
        
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Add unique constraint
            $table->integer('status')->default(1)->comment('0 for Inactive, 1 for Active'); // Adding a status column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
