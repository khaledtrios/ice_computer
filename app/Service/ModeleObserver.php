<?php

namespace App\Service;

use App\Models\Modele;
use App\Models\Panne;
use App\Models\Boutique;
use App\Models\ConfigurationBoutique;

class ModeleObserver
{
    public function created(Modele $modele)
    {
        $this->syncConfigurations($modele);
    }

    public function updated(Modele $modele)
    {
        $this->syncConfigurations($modele);
    }

    protected function syncConfigurations(Modele $modele)
    {
        $marque = $modele->marque;
        if (!$marque)
            return;

        $boutiques = Boutique::where('config_type', 'Devis')
            ->whereHas('configurations', function ($q) use ($marque) {
                $q->where('marque_id', $marque->id);
            })
            ->get();


        if ($boutiques->isEmpty())
            return;

        $pannes = Panne::where('is_deleted', false)
            ->where('materiel_id', $marque->materiel_id)
            ->get();

        foreach ($boutiques as $boutique) {
            $typesList = collect($boutique->types_par_panne ?? []);

            $pannesAvecTypes = $pannes->flatMap(function ($panne) use ($typesList) {
                return $typesList->map(function ($t) use ($panne) {
                    return [
                        'id' => $panne->id,
                        'nom' => $panne->nom_panne,
                        'description' => $panne->description,
                        'type' => $t['type'] ?? null,
                        'prix_initial' => 0,
                        'prix_promo' => 0,
                        'remise' => 0,
                        'afficher' => true,
                        'image' => $panne->image,
                        'priorite' => 0,
                        'couleurs' => [
                            'Noir',
                            'Blanc',
                            'Gris',
                            'Argent',
                            'Or',
                            'Or rose',
                            'Rose',
                            'Rouge',
                            'Bleu',
                            'Vert',
                            'Violet',
                            'Jaune',
                            'Corail',
                            'Orange',
                            'Marron',
                            'Beige',
                            'Autre'
                        ],
                    ];
                });
            })->values()->all();

            $capacites = [16, 32, 64, 128, 256];
            $rachats = collect([1, 2, 3])->flatMap(function ($type) use ($capacites) {
                return collect($capacites)->map(fn($cap) => [
                    'type' => $type,
                    'capacity' => $cap,
                    'price' => 0,
                ]);
            })->values()->all();

            ConfigurationBoutique::updateOrCreate(
                [
                    'modele_id' => $modele->id,
                    'marque_id' => $marque->id,
                    'boutique_id' => $boutique->id,
                ],
                [
                    'materiel_id' => $marque->materiel_id,
                    'pannes' => $pannesAvecTypes,
                    'rachat' => $rachats,
                    'rachat_affiche' => false,
                ]
            );
        }
    }
}