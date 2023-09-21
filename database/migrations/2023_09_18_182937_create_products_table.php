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
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('vendor_id')->nullable();
            $table->string('product_name');
            $table->string('product_slug');
            $table->string('product_code');
            $table->string('product_qty');
            $table->string('product_tags')->nullable();
            $table->string('product_size')->nullable();
            $table->string('product_color')->nullable();
            $table->string('product_price');
            $table->string('product_discount')->nullable();
            $table->text('product_short_description');
            $table->text('product_long_description');
            $table->string('product_thambnail');
            $table->integer('product_hot_deals')->nullable();
            $table->integer('product_features')->nullable();
            $table->integer('product_special_offer')->nullable();
            $table->integer('product_special_deals')->nullable();
            $table->integer('product_status')->default(0);
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
            $table->dropColumn('brand_id');
            $table->dropColumn('category_id');
            $table->dropColumn('subcategory_id');
            $table->dropColumn('vendor_id');
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
            $table->dropColumn('product_features');
            $table->dropColumn('product_special_offer');
            $table->dropColumn('product_special_deals');
            $table->dropColumn('product_status');
        });

        Schema::dropIfExists('products');
    }
};
