<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pannes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materiel_id')->nullable();
            $table->string('nom_panne')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->Integer('priorite')->default(0)->nullable();
            $table->boolean('colors')->default(0)->nullable();
            $table->foreign('materiel_id')->references('id')->on('materiels');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pannes');
    }
};
