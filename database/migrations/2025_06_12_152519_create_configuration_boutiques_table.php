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
        Schema::create('configuration_boutiques', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('set null');

            $table->unsignedBigInteger('marque_id')->nullable();
            $table->foreign('marque_id')->references('id')->on('marques')->onDelete('set null');

            $table->unsignedBigInteger('modele_id')->nullable();
            $table->foreign('modele_id')->references('id')->on('modeles')->onDelete('set null');

            $table->unsignedBigInteger('materiel_id')->nullable();
            $table->foreign('materiel_id')->references('id')->on('materiels')->onDelete('set null');

            $table->json('pannes')->nullable();
            $table->json('rachat')->nullable();
            $table->string('rachat_affiche')->nullable();

            $table->index('boutique_id');
            $table->index('materiel_id');
            $table->index('marque_id');
            $table->index('modele_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_boutiques');
    }
};
