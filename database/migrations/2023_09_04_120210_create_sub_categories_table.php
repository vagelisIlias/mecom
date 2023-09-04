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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('sub_category_name');
            $table->string('sub_category_slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        // Drop individual columns if needed
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('sub_category_name');
            $table->dropColumn('sub_category_slug');
        });

        Schema::dropIfExists('sub_categories');
    }
};
