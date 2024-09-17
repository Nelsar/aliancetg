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
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('category_id', 
                    'produts_category_id_fk')
                    ->references('id')
                    ->on('categories')
                    ->cascadeOnDelete();

            $table->foreign('brand_id', 
                        'products_brand_id_fk')
                        ->references('id')
                        ->on('brands')
                        ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function(Blueprint $table){
            $table->dropForeign('produts_category_id_fk');
            $table->dropForeign('products_brand_id_fk');
        });
        Schema::dropIfExists('products');
    }
};
