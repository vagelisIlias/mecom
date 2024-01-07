<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_brand_id');
            $table->integer('product_category_id');
            $table->integer('product_subcategory_id');
            $table->string('product_vendor_id')->nullable();
            $table->string('product_name');
            $table->string('product_slug')->unique();
            $table->string('product_code');
            $table->string('product_qty');
            $table->string('product_tags')->nullable();
            $table->string('product_size')->nullable();
            $table->string('product_color')->nullable();
            $table->string('product_price');
            $table->string('product_discount')->nullable();
            $table->string('product_short_description');
            $table->text('product_long_description');
            $table->string('product_thambnail')->nullable();
            $table->string('product_hot_deals')->nullable();
            $table->string('product_featured')->nullable();
            $table->string('product_special_offer')->nullable();
            $table->string('product_special_deals')->nullable();
            $table->string('product_status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        // Drop individual columns if needed
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_brand_id');
            $table->dropColumn('product_category_id');
            $table->dropColumn('product_subcategory_id');
            $table->dropColumn('product_vendor_id');
            $table->dropColumn('product_name');
            $table->dropColumn('product_slug');
            $table->dropColumn('product_code');
            $table->dropColumn('product_qty');
            $table->dropColumn('product_tags');
            $table->dropColumn('product_size');
            $table->dropColumn('product_color');
            $table->dropColumn('product_price');
            $table->dropColumn('product_discount');
            $table->dropColumn('product_short_description');
            $table->dropColumn('product_long_description');
            $table->dropColumn('product_thambnail');
            $table->dropColumn('product_hot_deals');
            $table->dropColumn('product_featured');
            $table->dropColumn('product_special_offer');
            $table->dropColumn('product_special_deals');
            $table->dropColumn('product_status');
        });

        Schema::dropIfExists('products');
    }
};
