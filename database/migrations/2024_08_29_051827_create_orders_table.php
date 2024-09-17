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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            $table->foreign('product_id', 
                    'orders_product_id_foreign')
                    ->references('id')
                    ->on('products')
                    ->cascadeOnDelete();

            $table->foreign('user_id', 
                'orders_user_id_foreign')
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
        Schema::table('orders', function(Blueprint $table) {
            $table->dropForeign('orders_product_id_foreign');
            $table->dropForeign('orders_user_id_foreign');
        });
        Schema::dropIfExists('orders');
    }
};
