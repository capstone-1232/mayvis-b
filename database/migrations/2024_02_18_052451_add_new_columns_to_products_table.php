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
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_name');
            $table->string('product_notes')->nullable();
            $table->text('product_description');
            $table->decimal('price', 8, 2);
            $table->foreignId('category_id')->constrained(); // foreign key for products
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            
            // First, drop the foreign key constraint
            $table->dropForeign(['category_id']);
            $table->dropColumn('product_name');
            $table->dropColumn('product_notes');
            $table->dropColumn('product_description');
            $table->dropColumn('price');
            $table->dropColumn('category_id'); 
        });
    }
};
