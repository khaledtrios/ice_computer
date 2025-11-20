<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('message')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_admin')->default(0)->nullable();
            $table->unsignedBigInteger('support_id')->nullable();
            $table->foreign('support_id')->references('id')->on('supports');
            $table->boolean('is_read')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
