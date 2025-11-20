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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boutique_id')->index()->nullable();
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('set null');
            $table->string('domain_name')->unique();
            $table->string('width')->default(100); // 'primary' or '
            $table->string('height')->default(100); // 'secondary'
            $table->string('iframe_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
