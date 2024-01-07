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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('slug')->unique();
            $table->string('github')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('website')->nullable();
            $table->text('job_title')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('vendor_shop_name')->nullable();
            $table->text('vendor_short_info')->nullable();
            $table->enum('role', ['admin', 'vendor', 'user'])->default('user');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        // Drop individual columns if needed
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('username');
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('password');
            $table->dropColumn('slug');
            $table->dropColumn('github');
            $table->dropColumn('instagram');
            $table->dropColumn('linkedin');
            $table->dropColumn('facebook');
            $table->dropColumn('website');
            $table->dropColumn('job_title');
            $table->dropColumn('password');
            $table->dropColumn('photo');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('postcode');
            $table->dropColumn('vendor_shop_name');
            $table->dropColumn('vendor_short_info');
            $table->dropColumn('role');
            $table->dropColumn('status');
        });

        // Drop the table itself
        Schema::dropIfExists('users');
    }
};

