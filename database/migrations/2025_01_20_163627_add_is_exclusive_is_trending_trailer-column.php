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
        Schema::table('movies', function (Blueprint $table) {
            //
            $table->integer('isExclusive')->default(1)->comment('0 for false, 1 for true');
            $table->integer('isTrending')->default(1)->comment('0 for false, 1 for true'); // Adding a status column
            $table->text('trailler');
            $table->date('release_date')->nullable();
            $table->integer('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            //
            $table->dropColumn('isExclusive');
            $table->dropColumn('isTrending');
            $table->dropColumn('trailler');
            $table->dropColumn('release_date');
            $table->dropColumn('duration');
        });
    }
};
