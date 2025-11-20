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
        Schema::create('order_models', function (Blueprint $table) {
            $table->id();

            // Pas besoin de $table->id() deux fois, supprimé le doublon

            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('set null');

            $table->unsignedBigInteger('modele_id')->nullable();
            $table->foreign('modele_id')->references('id')->on('modeles')->onDelete('set null');

            $table->integer('position')->default(1);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_models');
    }
};
