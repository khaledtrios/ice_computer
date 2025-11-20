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
        Schema::create('modeles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('boutique_id')->nullable()->default(null);

            $table->unsignedBigInteger('marque_id')->nullable();
            $table->foreign('marque_id')->references('id')->on('marques')->onDelete('set null');


            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');

            $table->string('nom_modele')->nullable();
            $table->string('image')->nullable();
            $table->integer('priorite')->default(0);
            $table->boolean('is_validate')->default(1)->nullable();
            $table->string('is_deleted')->default(0);

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
        Schema::dropIfExists('modeles');
    }
};
