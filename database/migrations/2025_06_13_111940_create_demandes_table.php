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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_devis')->nullable();

            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('set null');

            $table->unsignedBigInteger('modele_id')->nullable();
            $table->foreign('modele_id')->references('id')->on('modeles')->onDelete('set null');

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');

            $table->unsignedBigInteger('statut_id')->nullable();
            $table->foreign('statut_id')->references('id')->on('statuts')->onDelete('set null');

            $table->json('pannes')->nullable();

            $table->boolean('type')->nullable()->comment('0 = Rendez-vous | 1 = Devis');
            $table->string('date_rendez_vous')->nullable();

            $table->string('global_remise')->nullable();

            $table->string('commentaire')->nullable();

            $table->boolean('is_deleted')->default(0)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
