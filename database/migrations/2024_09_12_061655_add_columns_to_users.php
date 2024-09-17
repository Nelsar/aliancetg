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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('phone_invite')->nullable();
            $table->unsignedBigInteger('iin')->nullable();
            $table->string('last_name')->nullable();
            $table->string('patronymic')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('gender')->default(0);
            $table->string('refferal_code')->nullable();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->unsignedBigInteger('admin_id')->default(0);
            $table->integer('balance')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
