<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('seat_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Silver, Gold, Platinum
            $table->timestamps();
        });

        // Seed default categories
        DB::table('seat_categories')->insert([
            ['name' => 'silver'],
            ['name' => 'gold'],
            ['name' => 'platinum'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('seat_categories');
    }
};
