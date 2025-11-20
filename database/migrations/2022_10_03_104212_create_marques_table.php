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
        Schema::create('marques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materiel_id')->nullable();
            $table->foreign('materiel_id')->references('id')->on('materiels');
            $table->string('nom_marques')->nullable();
            $table->string('image')->nullable();
            $table->integer('priorite')->default(0);
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
        Schema::dropIfExists('marques');
    }
};
