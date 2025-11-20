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
        Schema::create('boutique_preview_couleurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');

            // Corriger les noms de colonnes : les tirets (-) ne sont pas autorisés
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boutique_preview_couleurs');
    }
};
