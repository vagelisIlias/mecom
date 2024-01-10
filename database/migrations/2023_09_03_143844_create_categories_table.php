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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->string('category_slug');
            $table->string('category_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop individual columns if needed
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('category_name');
            $table->dropColumn('category_slug');
            $table->dropColumn('category_name');
        });
        Schema::dropIfExists('categories');
    }
};
