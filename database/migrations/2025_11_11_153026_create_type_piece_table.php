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
        Schema::create('type_piece', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('boutique_id')->nullable()->index();
            $table->foreign('boutique_id')
                ->references('id')
                ->on('boutiques')
                ->onDelete('cascade'); 
            
            $table->boolean('is_qualirepar')->nullable()->default(0);
            $table->string('name')->nullable();
            $table->decimal("montant", 8,2);
            
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_piece');
    }
};
