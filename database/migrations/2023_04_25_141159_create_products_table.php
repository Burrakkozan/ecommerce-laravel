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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 2048)->nullable();
            $table->string('alt_image', 2048)->nullable();
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('slug',160);
            $table->string('product_name',150);
            $table->text('product_detail');
            $table->unsignedBigInteger('product_qty')->default(0);
            $table->string('product_size')->nullable();
            $table->string('product_color')->nullable();
            $table->integer('hot_deals')->nullable();
            $table->integer('featured')->nullable();
            $table->integer('special_offer')->nullable();
            $table->integer('special_deals')->nullable();
            $table->decimal('selling_price');
            $table->decimal('discount_price')->nullable();
            $table->integer('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
