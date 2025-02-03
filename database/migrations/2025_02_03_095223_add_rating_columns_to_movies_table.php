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
            $table->decimal('average_rating', 3, 2)->default(0)->after('duration');
            $table->unsignedInteger('ratings_count')->default(0)->after('average_rating');
            $table->unsignedInteger('tomatometer')->nullable()->after('ratings_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            //
            $table->dropColumn('average_rating');
            $table->dropColumn('ratings_count');
            $table->dropColumn('tomatometer');
        });
    }
};
