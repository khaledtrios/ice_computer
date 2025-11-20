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
        Schema::create('dayoffs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('boutique_id')->nullable()->index();
            $table->foreign('boutique_id')
                ->references('id')
                ->on('boutiques')
                ->onDelete('cascade'); 

            $table->date('jour_conge')->nullable();

            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dayoffs');
    }
};
