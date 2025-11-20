<?php

namespace Database\Seeders;

use App\Models\Statut;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatutSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataStatuts = [
            // Rendez-vous
            ['nom_statut' => "en cours", 'is_statut' => 0],
            ['nom_statut' => "Envoyez et en traitemant", 'is_statut' => 0],
            ['nom_statut' => "Rejetè", 'is_statut' => 0],
            ['nom_statut' => "En attente de confirmation", 'is_statut' => 0],
            ['nom_statut' => "Confirmé", 'is_statut' => 0],
            ['nom_statut' => "Annulé par client", 'is_statut' => 0],
            ['nom_statut' => "Annulé par boutique", 'is_statut' => 0],
            ['nom_statut' => "Terminé", 'is_statut' => 0],
            ['nom_statut' => "Non honoré", 'is_statut' => 0],

            // Devis
            ['nom_statut' => "en cours", 'is_statut' => 1],
            ['nom_statut' => "Envoyez et en traitemant", 'is_statut' => 1],
            ['nom_statut' => "Rejetè", 'is_statut' => 1],
            ['nom_statut' => "En attente de validation", 'is_statut' => 1],
            ['nom_statut' => "Validé par client", 'is_statut' => 1],
            ['nom_statut' => "Refusé par client", 'is_statut' => 1],
            ['nom_statut' => "Accepté et en préparation", 'is_statut' => 1],
            ['nom_statut' => "Terminé", 'is_statut' => 1],
            ['nom_statut' => "Facturé", 'is_statut' => 1],
        ];

        foreach ($dataStatuts as $statut) {
            Statut::create($statut);
        }
    }
}
