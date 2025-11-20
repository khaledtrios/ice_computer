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
        Schema::create('produit_additionnels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boutique_id')->nullable()->index();
            $table->foreign('boutique_id')
                ->references('id')
                ->on('boutiques')
                ->onDelete('cascade'); 
            $table->unsignedBigInteger('materiel_id')->nullable()->index();
            $table->foreign('materiel_id')
                ->references('id')
                ->on('materiels')
                ->onDelete('cascade');  
            
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->decimal("price", 8,2);
            $table->string('image')->nullable();

            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_additionnels');
    }
};
