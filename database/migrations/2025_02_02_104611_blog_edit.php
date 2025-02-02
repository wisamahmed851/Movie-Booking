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

        Schema::table('blog_details', function (Blueprint $table) {
            //
            $table->dropColumn('short_description');
            $table->text('short_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_details', function (Blueprint $table) {
            //
            $table->dropColumn('short_description');
            $table->string('short_description');
        });
    }
};
