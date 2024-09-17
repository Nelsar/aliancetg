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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('count');
            $table->timestamps();
            $table->foreign('product_id', 
                    'carts_product_id_foreign')
                    ->references('id')
                    ->on('products')
                    ->cascadeOnDelete();

            $table->foreign('user_id', 
                    'carts_user_id_foreign')
                    ->references('id')
                    ->on('users')
                    ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function(Blueprint $table) {
            $table->dropForeign('carts_product_id_foreign');
            $table->dropForeign('carts_user_id_foreign');
        });
        Schema::dropIfExists('carts');
    }
};
