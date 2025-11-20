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
        Schema::create('boutiques', function (Blueprint $table) {
           $table->id();

        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('hosts', 256)->nullable()->default('[]');
        $table->string('slug')->unique();
        $table->string('config_type')->nullable();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

        $table->string('nom_boutique')->nullable();
        $table->string('telephone')->nullable();
        $table->json('adresse')->nullable();
        $table->string('city')->nullable();
        $table->string('company')->nullable();
        $table->string('code_postal')->nullable();
        $table->string('siret', 20)->nullable();
        $table->integer('libalise')->default(0);

        // Horaires
        $table->json('Monday')->nullable();
        $table->json('Tuesday')->nullable();
        $table->json('Wednesday')->nullable();
        $table->json('Thursday')->nullable();
        $table->json('Friday')->nullable();
        $table->json('Saturday')->nullable();
        $table->json('Sunday')->nullable();

        // Pannes
        $table->json('types_par_panne')->nullable();

        $table->boolean('is_blocked')->nullable()->default(1);

        // Réparation en magasin
        $table->integer('reparation_magazin')->nullable()->default(0);
        $table->double('reparation_magazin_price', 8, 2)->nullable()->default(0.00);
        $table->string('reparation_magazin_description', 256)->nullable()->default('Votre appareil réparé en 30 minutes sur place !');

        // Réparation à domicile
        $table->integer('reparation_domicile')->nullable()->default(0);
        $table->double('reparation_domicile_price', 8, 2)->nullable()->default(0.00);
        $table->string('reparation_domicile_description', 256)->nullable()->default("Intervention en moins d'une heure dans toute l'Île-de-France !");

        // Réparation par correspondance
        $table->integer('reparation_correspondance')->nullable()->default(0);
        $table->double('reparation_correspondance_price', 8, 2)->nullable()->default(0.00);
        $table->string('reparation_correspondance_description', 256)->nullable()->default('Mail order repair in 120min');

        // Couleurs
        $table->string('primary_color', 256)->nullable()->default('#7650e0');
        $table->string('secondary_color')->nullable();

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
        Schema::dropIfExists('boutiques');
    }
};
