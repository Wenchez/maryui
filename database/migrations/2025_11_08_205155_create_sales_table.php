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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_id');
            $table->dateTime('sale_date');
            $table->string('sale_reference', 20)->unique();
            $table->unsignedInteger('user_id')->nullable();
            $table->decimal('sale_subtotal', 10, 2)->default(0.00);
            $table->decimal('sale_tax', 10, 2)->default(0.00);
            $table->decimal('sale_total', 10, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
