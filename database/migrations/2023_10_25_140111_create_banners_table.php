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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title');
            $table->string('banner_url');
            $table->string('banner_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
         // Drop individual columns if needed
         Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('banner_title');
            $table->dropColumn('banner_url');
            $table->dropColumn('banner_image');
        });
        Schema::dropIfExists('banners');
    }
};