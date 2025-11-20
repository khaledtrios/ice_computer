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
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->foreign('boutique_id')->references('id')->on('boutiques');
            $table->string('objet')->nullable();
            $table->string('message')->nullable();
            $table->boolean('status')->default(0)->nullable()->comment('0: fermé, 1: ouvert');
            $table->boolean('is_oppen')->default(0)->nullable()->comment('0: fermé, 1: ouvert');
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
        Schema::dropIfExists('supports');
    }
};
