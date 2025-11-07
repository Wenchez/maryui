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
            $table->id('product_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('product_type_id');
            $table->date('product_date');
            $table->string('product_code', 50)->unique();
            $table->string('product_name', 255);
            $table->integer('product_stock')->default(0);
            $table->decimal('product_price', 10, 2);
            $table->enum('product_gender', ['male', 'female', 'unisex'])->default('unisex')->after('type_name');
            $table->string('product_image')->nullable();
            $table->enum('product_availability_status', ['available', 'discontinued'])->default('available');
            $table->enum('product_stock_status', ['inStock', 'stockOut'])->default('inStock');
            $table->timestamps();

            $table->foreign('brand_id')
                  ->references('brand_id')
                  ->on('brands')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('product_type_id')
                  ->references('product_type_id')
                  ->on('product_types')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
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
