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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('brand_slug');
            $table->string('brand_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop individual columns if needed
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('brand_name');
            $table->dropColumn('brand_slug');
            $table->dropColumn('brand_image');
        });
        Schema::dropIfExists('brands');
    }
};
