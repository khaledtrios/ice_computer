<?php

namespace App\Http\Controllers\boutique;

use App\Enums\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PanneResource;
use App\Models\Boutique;
use App\Models\ConfigurationBoutique;
use App\Models\Marque;
use App\Models\Materiel;
use App\Models\Modele;
use App\Models\Notification;
use App\Models\Panne;
use App\Models\TypePiece;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ConfigurationController extends Controller
{
    public function index()
    {
        Notification::where('type', NotificationType::resinstallerConfiguration)
            ->where('boutique_id', Auth::id())
            ->update(['is_oppen' => 1]);

        // $config = ConfigurationBoutique::where('id', 244729)->first();
        // $pannesRaw = collect($config->pannes ?? []);

        // $grouped = $pannesRaw->groupBy(function ($item) {
        //     return $item['id'].'|'.$item['nom'].'|'.($item['image'] ?? '');
        // });
        // dd($grouped);

        return view('boutique.configuration.index');
    }

    public function getMaterials()
    {
        $materials = Materiel::where('is_deleted', 0)->get();
        $userId = Auth::id();
        $boutique = Boutique::where('user_id', $userId)->first();

        if (! $boutique) {
            return response()->json([
                'materials' => $materials,
                'selectedMatriels' => collect(),
            ]);
        }

        $configurations = ConfigurationBoutique::where('boutique_id', $boutique->id)
            ->get(['materiel_id']);

        $selectedMatrielsIds = $configurations->pluck('materiel_id');
        $selectedMatriels = Materiel::whereIn('id', $selectedMatrielsIds)->get();

        return response()->json([
            'materials' => $materials,
            'selectedMatriels' => $selectedMatriels,
        ]);
    }

    public function brands($material)
    {
        $brands = Marque::where('materiel_id', $material)
            ->where('is_deleted', 0)
            ->get();

        $boutique = Boutique::where('user_id', Auth::id())->first();

        $selectedBrandIds = ConfigurationBoutique::where('boutique_id', $boutique->id)
            ->pluck('marque_id');

        $selectedBrands = Marque::whereIn('id', $selectedBrandIds)->get();

        return response()->json([
            'brands' => $brands,
            'selectedBrands' => $selectedBrands,
        ]);
    }

    public function models($brand)
    {
        $boutique = Boutique::where('user_id', Auth::id())->first();

        $models = Modele::where('marque_id', $brand)->orderBy('created_at', 'asc')->get();
        $selectedModelsds = ConfigurationBoutique::where('boutique_id', $boutique->id)
            ->pluck('modele_id');
        $selectedModels = Modele::whereIn('id', $selectedModelsds)->get();

        return response()->json(
            [
                'models' => $models,
                'selectedModels' => $selectedModels,
                'configurationids' => $selectedModels->pluck('id'),
            ]
        );
    }

    public function PanneModelWithTypePanneEtRachat($brand)
    {
        $marque = Marque::findOrFail($brand);
        $pannes = Panne::where('is_deleted', false)->where('materiel_id', $marque->materiel_id)->orderBy('priorite', 'asc')->get();

        return response()->json($pannes);
    }

    public function configurationSelonModeRequest(Request $request)
    {

        $validated = $request->validate([
            'material' => 'nullable',
            'mode' => 'nullable|in:Devis,Rendez-vous',
            'modeRequest' => 'nullable|in:Devis,Rendez-vous',
            'brands' => 'nullable|array',
            'brands.*.id' => 'nullable|exists:marques,id',
            'models' => 'nullable|array',
            'models.*.id' => 'nullable|exists:modeles,id',
            'parts' => 'nullable|array',
            'prices' => 'nullable|array',
            'appointment_type' => 'nullable',
            'modalModel' => 'nullable|array',
            'modalModel.id' => 'nullable|exists:modeles,id',
            'pannes' => 'nullable|array',
            'prixParCapacite' => 'nullable|array',
            'prixParCapacite.*' => 'array',
            'prixParCapacite.*.*' => 'nullable|numeric|min:0',
            'showPriceTable' => 'nullable|boolean',
        ]);

        $modeRequest = $validated['mode'] ?? $validated['modeRequest'] ?? null;                // 'Devis' | 'Rendez-vous' | null
        $parts = collect($validated['parts'] ?? []);        // [{type: ...}, ...]
        $brands = collect($validated['brands'] ?? []);
        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();

        // FIX: Initialize to null to avoid undefined variable error
        $configmode = null;

        // Sécurité serveur : si un mode est déjà fixé et qu’on tente d’en changer
        if ($modeRequest && $boutique->config_type && $boutique->config_type !== $modeRequest) {
            return response()->json([
                'error' => "Le mode est déjà défini sur '{$boutique->config_type}'. Changement interdit.",
            ], 422);
        }

        // Initialisation/MAJ du mode + types par panne si fournis
        if ($modeRequest === 'Devis') {
            $boutique->update([
                'config_type' => $modeRequest,
                // 'types_par_panne' => $parts, // on garde la structure fournie (tableau d’objets {type})
            ]);
            $parts = $validated['parts'] ?? [];
            $partIds = [];
            $typesIds = $boutique->types_piece()->pluck('id')->toArray();
            if (is_array($parts) && count($parts) > 0) {
                foreach ($parts as $part) {
                    if (array_key_exists('id', $part)) {
                        $typePiece = TypePiece::updateorcreate(['id' => $part['id']], [
                            'name' => $part['name'],
                            'is_qualirepar' => $part['is_qualirepar']??0,
                            'montant' => $part['montant']??0,
                            'boutqiue_id' => $boutique->id,
                        ]);
                        $partIds[] = $typePiece->id;
                    } else {
                        $typePiece = TypePiece::updateorcreate(['name' => $part['name'],
                            'boutique_id' => $boutique->id,], [
                            'is_qualirepar' => $part['is_qualirepar']??0,
                            'montant' => $part['montant']??0,
                            'boutique_id' => $boutique->id,
                        ]);
                        $partIds[] = $typePiece->id;
                    }
                }
                $typesRemoveIds = array_diff($typesIds, $partIds);
                TypePiece::whereIn('id', $typesRemoveIds)->where('boutique_id', $boutique->id)->delete();
            }
            

        }
        // | 3) Mode "Devis" : graines de config pour chaque modèle des marques
        if ($modeRequest === 'Devis') {

            // Marque(s) désélectionnées -> suppression des configs associées
            $existingBrandIds = ConfigurationBoutique::where('boutique_id', $boutique->id)
                ->pluck('marque_id')->unique();
            $newBrandIds = $brands->pluck('id');
            $deselectedBrandIds = $existingBrandIds->diff($newBrandIds);

            if ($deselectedBrandIds->isNotEmpty()) {
                ConfigurationBoutique::where('boutique_id', $boutique->id)
                    ->whereIn('marque_id', $deselectedBrandIds)
                    ->delete();
            }

            $typesPieces = TypePiece::where('boutique_id', $boutique->id)->get();
            $brands->each(function ($brandData) use ($boutique, $typesPieces) {
                $brandId = data_get($brandData, 'id');
                $brand = $brandId ? Marque::find($brandId) : null;
                if (! $brand) {
                    return;
                }

                $models = Modele::where('marque_id', $brand->id)->get();

                foreach ($models as $model) {
                    // Pannes BDD liées au matériel de la marque
                    $pannesBdd = Panne::where('is_deleted', false)
                        ->where('materiel_id', $brand->materiel_id)
                        ->get();

                    // On fabrique les pannes "à plat" en dupliquant chaque panne par type (depuis $parts)
                    // $pannesAvecTypes = $this->mapPannes(collect($pannesBdd), $parts); $typesAssocies
                    $pannesAvecTypes = [];
                    foreach ($pannesBdd as $panne) {
                        $typesFormates = [];
                        foreach ($typesPieces as $type) {
                            $typesFormates[] = [
                                'id' => $type->id ?? null,
                                'nom' => $type->name ?? null,
                                'montant' => $type->montant ?? null,
                                'is_qualirepar' => $type->is_qualirepar ?? 0,
                                'prix_achat' => 0,
                                'prix_initial' => 0,
                                'prix_promo' => 0,
                                // 'remise' => 0,
                                'afficher' => true,
                            ];
                        }

                        $pannesAvecTypes[] = [
                            'id' => $panne->id,
                            'nom' => $panne->nom_panne,
                            'image' => $panne->image,
                            'is_qualirepar' => $panne->is_qualirepar,
                            'types' => $typesFormates,
                        ];
                    }

                    // Rachat par défaut (toutes capacités, 0) + non affiché
                    $capacites = [16, 32, 64, 128, 256];
                    $rachats = collect([1, 2, 3])->flatMap(function ($type) use ($capacites) {
                        return collect($capacites)->map(fn ($cap) => [
                            'type' => $type,
                            'capacity' => $cap,
                            'price' => 0,
                        ]);
                    })->values()->all();

                    ConfigurationBoutique::updateOrCreate(
                        [
                            'modele_id' => $model->id,
                            'marque_id' => $brand->id,
                            'boutique_id' => $boutique->id,
                        ],
                        [
                            'materiel_id' => $brand->materiel_id,
                            'pannes' => $pannesAvecTypes,
                            'rachat' => $rachats,
                            'rachat_affiche' => false,
                        ]
                    );
                }
            });
        }

        /* -----------------------------------------------------------------
         | 4) Mode "Rendez-vous" : MAJ via modal d’un modèle précis
         * -----------------------------------------------------------------*/
        if ($boutique->config_type === 'Rendez-vous' && ! empty(data_get($validated, 'modalModel.id'))) {

            $model = Modele::find(data_get($validated, 'modalModel.id'));
            if (! $model) {
                return response()->json(['error' => 'Modèle introuvable'], 404);
            }

            // Pannes envoyées depuis le front
            $pannesRequest = collect($validated['pannes'] ?? []);

            // Liste des types depuis la boutique (ex: [{type: "original"}, {type: "compatible"}])
            $typesList = collect($boutique->types_par_panne ?? []);

            // Normalisation pannes (on accepte deux sources :
            // - pannes BDD + duplication par $typesList
            // - pannes du front déjà structurées avec "types")
            // $pannesAvecTypes = $this->mapPannes($pannesRequest, $typesList);
            $pannesAvecTypes = $validated['pannes'];
            // Rachat (prix rachat bon état) depuis le front
            $prixParCapacite = $validated['prixParCapacite'] ?? [];
            $showRachat = (bool) ($validated['showPriceTable'] ?? false);
            $capacitesAll = [16, 32, 64, 128, 256];

            // On remplit tous les types avec les prix fournis, sinon 0.
            $rachats = collect([1, 2, 3])->flatMap(function ($type) use ($capacitesAll, $prixParCapacite) {
                return collect($capacitesAll)->map(function ($cap) use ($type, $prixParCapacite) {
                    $price = (float) Arr::get($prixParCapacite, "{$type}.{$cap}", 0);

                    return [
                        'type' => $type,
                        'capacity' => $cap,
                        'price' => $price,
                    ];
                });
            })->values()->all();

            $configmode = ConfigurationBoutique::updateOrCreate(
                [
                    'modele_id' => $model->id,
                    'marque_id' => $model->marque_id,
                    'boutique_id' => $boutique->id,
                ],
                [
                    'materiel_id' => $model->marque->materiel_id,
                    'pannes' => $pannesAvecTypes,
                    'rachat' => $rachats,
                    'rachat_affiche' => $showRachat,
                ]
            );

            \Log::info('configmode.mise_a_jour', [
                'modele_id' => $model->id,
                'pannes' => $configmode->pannes,
                'rachat' => $configmode->rachat,
                'affiche' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Configuration enregistrée avec succès.',
            'data' => $configmode,
            'type_pannes' => $boutique->types_par_panne,
        ]);
    }

    /**
     * Normalise la structure des pannes en dupliquant chaque panne pour chaque "type"
     * (ex: original/compatible), et en acceptant à la fois:
     *   - une collection issue de la BDD (pannes sans "types") + $typesList
     *   - une collection venant du front déjà avec "types"
     *
     * @param  \Illuminate\Support\Collection|null  $typesList  ex: collect([['type'=>'original'], ['type'=>'compatible']])
     */
    private function mapPannes(Collection $pannes, ?Collection $typesList = null): array
    {
        return $pannes->flatMap(function ($panne) use ($typesList) {
            // "types" envoyé depuis le front ?
            $typesFromRequest = collect(data_get($panne, 'types', []));

            // Si pas de types dans la requête (cas pannes BDD), on sème à partir de $typesList
            $types = $typesFromRequest->isNotEmpty()
                ? $typesFromRequest
                : collect($typesList ?? [])->map(function ($t) {
                    $label = data_get($t, 'type'); // support [{type: "..."}]

                    return [
                        'nom' => ['type' => $label],
                        'prix_initial' => 0,
                        'prix_promo' => 0,
                        // 'remise' => 0,
                        'priorite' => 0,
                        'afficher' => true,
                    ];
                });

            return $types->map(function ($type) use ($panne) {
                return (new PanneResource((object) [
                    'id' => data_get($panne, 'id'),
                    'nom' => data_get($panne, 'nom') ?? data_get($panne, 'nom_panne', ''),
                    'description' => data_get($panne, 'description'),
                    'type' => data_get($type, 'nom.type'),
                    'prix_initial' => (float) data_get($type, 'prix_initial', 0),
                    'prix_promo' => (float) data_get($type, 'prix_promo', 0),
                    // 'remise' => (float) data_get($type, 'remise', 0),
                    'afficher' => (bool) data_get($type, 'afficher', true),
                    'image' => data_get($panne, 'image'),
                    'priorite' => (int) data_get($panne, 'priorite', 0),

                ]))->toArray(request());
            });
        })->values()->all();
    }

    public function getPannesEtTypes($brand, $modele)
    {
        $marque = Marque::findOrFail($brand);

        $pannes = Panne::where('is_deleted', false)
            ->where('materiel_id', $marque->materiel_id)
            ->orderBy('priorite', 'asc')
            ->get();

        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();

        $config = ConfigurationBoutique::where('boutique_id', $boutique->id)
            ->where('marque_id', $marque->id)
            ->where('modele_id', $modele)
            ->first();

        $pannesAvecTypes = [];

        $prixParCapacite = [
            1 => [16 => 0, 32 => 0, 64 => 0, 128 => 0, 256 => 0],
            2 => [16 => 0, 32 => 0, 64 => 0, 128 => 0, 256 => 0],
            3 => [16 => 0, 32 => 0, 64 => 0, 128 => 0, 256 => 0],
        ];
        $showPriceTable = false;

        if ($config) {
            $rachats = collect($config->rachat ?? []);
            $prixParCapacite = $rachats->groupBy('type')->map(function ($group) {
                return $group->pluck('price', 'capacity')->all();
            })->all();
            $showPriceTable = $config->rachat_affiche;
        }

        if (! $config) {
            $typesAssocies = TypePiece::where('boutique_id', $boutique->id)->get();
            foreach ($pannes as $panne) {
                $typesFormates = [];
                foreach ($typesAssocies as $type) {
                    $typesFormates[] = [
                        'id' => $type->id ?? null,
                        'nom' => $type->name ?? null,
                        'montant' => $type->montant ?? null,
                        'is_qualirepar' => $type->is_qualirepar ?? 0,
                        'prix_achat' => 0,
                        'prix_initial' => 0,
                        'prix_promo' => 0,
                        // 'remise' => 0,
                        'afficher' => true,
                    ];
                }

                $pannesAvecTypes[] = [
                    'id' => $panne->id,
                    'nom' => $panne->nom_panne,
                    'image' => $panne->image,
                    'is_qualirepar' => $panne->is_qualirepar,
                    'types' => $typesFormates,
                ];
            }
        } else {
            $pannesRaw = $config->pannes ?? [];
            $typesAssocies = TypePiece::where('boutique_id', $boutique->id)->get()->keyby('id');

            $pannesAvecTypes = [];
            foreach ($pannesRaw as $row) {
                $panne = Panne::find($row['id']);
                if (! is_null($panne)) {
                    $arr = [];
                    $arr['id'] = $panne->id;
                    $arr['nom'] = $panne->nom_panne;
                    $arr['image'] = $panne->image;
                    $arr['is_qualirepar'] = $panne->is_qualirepar;
                    foreach ($row['types'] as $type) {
                        $typepiece = TypePiece::find($type['id']);
                        if (! is_null($typepiece)) {
                            $arr['types'][] = [
                                'id' => $typepiece->id,
                                'nom' => $typepiece->name,
                                'montant' => $typepiece->montant,
                                'is_qualirepar' => $typepiece->is_qualirepar,
                                'prix_achat' => $type['prix_achat'] ?? 0,
                                'prix_initial' => $type['prix_initial'],
                                'prix_promo' => $type['prix_promo'],
                                // 'remise' => $type['remise'],
                                'afficher' => $type['afficher'],
                            ];
                        }

                    }
                }
                $pannesAvecTypes[] = $arr;
            }

        }

        return response()->json([
            'pannes' => $pannesAvecTypes,
            'prixParCapacite' => $prixParCapacite,
            'showPriceTable' => $showPriceTable,
        ]);
    }

    public function getExistingConfiguration()
    {
        $boutique = Boutique::where('user_id', Auth::id())->first();
        if ($boutique && $boutique->config_type) {
            return response()->json([
                'has_configuration' => true,
                'remise_online' => $boutique->remise_online,
                'mode' => $boutique->config_type,
                'types_par_panne' => $boutique->types_piece ?? [],
                'shop_addresses' => $boutique->adresse,

                'reparation_magazin' => $boutique->reparation_magazin,
                'reparation_magazin_price' => $boutique->reparation_magazin_price,
                'reparation_magazin_description' => $boutique->reparation_magazin_description,

                'reparation_domicile' => $boutique->reparation_domicile,
                'reparation_domicile_price' => $boutique->reparation_domicile_price,
                'reparation_domicile_description' => $boutique->reparation_domicile_description,

                'reparation_correspondance' => $boutique->reparation_correspondance,
                'reparation_correspondance_price' => $boutique->reparation_correspondance_price,
                'reparation_correspondance_description' => $boutique->reparation_correspondance_description,
            ]);
        }

        $addresses = $boutique ? $boutique->adresse : [];

        return response()->json([
            'has_configuration' => false,
            'mode' => null,
            'remise_online' => $boutique->remise_online,
            'types_par_panne' => $boutique->types_piece ?? [],
            'configurations' => [],
            'shop_addresses' => [],
            'reparation_magazin' => null,
            'reparation_magazin_price' => null,
            'reparation_magazin_description' => null,
            'reparation_domicile' => null,
            'reparation_domicile_price' => null,
            'reparation_domicile_description' => null,
            'reparation_correspondance' => null,
            'reparation_correspondance_price' => null,
            'reparation_correspondance_description' => null,
            'addresses' => $addresses,
        ]);
    }

    public function ConfigurationRendezVousStep1(Request $request)
    {
        $validated = $request->validate([
            'mode' => 'required|in:Devis,Rendez-vous',
            'parts' => 'nullable|array',
            'prices' => 'nullable|array',
            'appointment_options' => 'nullable|array',
            'shop_addresses' => 'nullable|array',
        ]);

        $parts = collect($validated['parts'] ?? []);
        $shop_addresses = collect($validated['shop_addresses'] ?? []);
        $appointment_options = collect($validated['appointment_options'] ?? []);
        $mode = $validated['mode'];

        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();

        $reparationMagazin = $appointment_options->firstWhere('id', 'typeRdv0');
        $reparationDomicile = $appointment_options->firstWhere('id', 'typeRdv1');
        $reparationCorrespondance = $appointment_options->firstWhere('id', 'typeRdv2') ?? null;
        $parts = $validated['parts'] ?? [];
        $partIds = [];
        
            $typesIds = $boutique->types_piece()->pluck('id')->toArray();
        if (is_array($parts) && count($parts) > 0) {
            foreach ($parts as $part) {
                if (array_key_exists('id', $part)) {
                    $typePiece = TypePiece::updateorcreate(['id' => $part['id']], [
                        'name' => $part['name'],
                        'is_qualirepar' => $part['is_qualirepar']??0,
                        'montant' => $part['montant']??0,
                        'boutqiue_id' => $boutique->id,
                    ]);
                    $partIds[] = $typePiece->id;
                } else {
                    $typePiece = TypePiece::updateorcreate(['name' => $part['name'],
                        'boutique_id' => $boutique->id,], [
                        'name' => $part['name'],
                        'is_qualirepar' => $part['is_qualirepar']??0,
                        'montant' => $part['montant']??0,
                        'boutique_id' => $boutique->id,
                    ]);
                    $partIds[] = $typePiece->id;
                }
            }
                $typesRemoveIds = array_diff($typesIds, $partIds);
                $dd = TypePiece::whereIn('id', $typesRemoveIds)->where('boutique_id', $boutique->id)->get();
                 
        }

        $boutique->update([
            'config_type' => $mode,
            'adresse' => $shop_addresses,
            'types_par_panne' => $parts,
            'remise_online' => $request->get('remiseOnline'),

            'reparation_magazin' => $reparationMagazin ? ($reparationMagazin['checked'] ?? false ? 1 : 0) : 0,
            'reparation_magazin_price' => $reparationMagazin && ($reparationMagazin['checked'] ?? false) ? ($reparationMagazin['price'] ?? 0) : 0,
            'reparation_magazin_description' => $reparationMagazin ? ($reparationMagazin['address'] ?? null) : null,

            'reparation_domicile' => $reparationDomicile ? ($reparationDomicile['checked'] ?? false ? 1 : 0) : 0,
            'reparation_domicile_price' => $reparationDomicile && ($reparationDomicile['checked'] ?? false) ? ($reparationDomicile['price'] ?? 0) : 0,
            'reparation_domicile_description' => $reparationDomicile ? ($reparationDomicile['address'] ?? null) : null,

            'reparation_correspondance' => $reparationCorrespondance ? ($reparationCorrespondance['checked'] ?? false ? 1 : 0) : 0,
            'reparation_correspondance_price' => $reparationCorrespondance && ($reparationCorrespondance['checked'] ?? false) ? ($reparationCorrespondance['price'] ?? 0) : 0,
            'reparation_correspondance_description' => $reparationCorrespondance ? ($reparationCorrespondance['address'] ?? null) : null,
        ]);

        return response()->json($boutique);
    }
}
