<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Mail\GenericDemandeEmail;
use App\Models\Boutique;
use App\Models\Client;
use App\Models\ConfigurationBoutique;
use App\Models\Dayoff;
use App\Models\Demande;
use App\Models\Marque;
use App\Models\Materiel;
use App\Models\Modele;
use App\Models\Notification;
use App\Models\TypePiece;
use App\Models\Panne;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ProduitAdditionnel;

class ApercuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showBoutique($slug)
    {
        $boutique = Boutique::where('slug', $slug)->first();

        // get days off return array dates ['2025/07/31', 2025/08/01']
        return view('front-office.demande.index', ['boutique' => $boutique]);
    }

    public function GetBoutiqueMatriel($boutique_id)
    {
        $boutique = Boutique::findOrFail($boutique_id);

        $matrielsIds = ConfigurationBoutique::where('boutique_id', $boutique_id)
            ->pluck('materiel_id')
            ->unique()
            ->toArray();

        $matriels = Materiel::where('is_deleted', 0)->whereIn('id', $matrielsIds)->get();

        return response()->json([
            'has_configuration' => ! empty($matrielsIds),
            'mode' => $boutique->config_type,
            'matriels' => $matriels,
        ]);
    }

    public function GetBoutiqueMarque($boutique_id, $materiel_id)
    {
        $marqueIds = ConfigurationBoutique::where('materiel_id', $materiel_id)->where('boutique_id', $boutique_id)->groupBy('marque_id')->pluck('marque_id')->toArray();
        $marque = Marque::whereIn('id', $marqueIds)->get();
 

        return response($marque);
    }

    public function GetBoutiqueProducts($boutique_id, $materiel_id)
    {
        $products = ProduitAdditionnel::where('boutique_id', $boutique_id)->where('materiel_id', $materiel_id)->get();

        return response($products);
    }

    public function GetModelBoutique($boutique_id, $marque_id)
    {
        $modeles = Modele::where('is_deleted', false)
            ->whereIn('id', function ($query) use ($boutique_id, $marque_id) {
                $query->select('modele_id')
                    ->from('configuration_boutiques')
                    ->where('boutique_id', $boutique_id)
                    ->where('marque_id', $marque_id)
                    ->groupBy('modele_id');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($modeles);
    }

    public function GetPannesModel($boutique_id, $modele_id)
    {
        $config = ConfigurationBoutique::where('boutique_id', $boutique_id)
            ->where('modele_id', $modele_id)
            ->first();
        // dd("hello");
        if (! $config) {
            return response()->json(['message' => 'Configuration non trouvée'], 404);
        }

        $prixRachat = [
            'bon' => [],
            'mauvais' => [],
            'piece' => [],
        ];

        foreach ($config->rachat as $item) {
            $capacity = $item['capacity'];
            $price = $item['price'];

            if ($item['type'] == 1) {
                $prixRachat['bon'][$capacity] = $price;
            } elseif ($item['type'] == 2) {
                $prixRachat['mauvais'][$capacity] = $price;
            } elseif ($item['type'] == 3) {
                $prixRachat['piece'][$capacity] = $price;
            }
        }

        $pannesRaw = $config->pannes ?? [];
        $typesAssocies = TypePiece::where('boutique_id', $boutique_id)->get()->keyby('id');

        $pannesAvecTypes = [];
        foreach ($pannesRaw as $row) {
            $panne = Panne::find($row['id']);
            if (! is_null($panne)) {
                $arr = [];
                $arr['id'] = $panne->id;
                $arr['nom'] = $panne->nom_panne;
                $arr['image'] = $panne->image;
                $arr['description'] = $panne->description;
                $arr['is_qualirepar'] = $panne->is_qualirepar;
                foreach ($row['types'] as $type) {
                    $typepiece = TypePiece::find($type['id']);
                    if (! is_null($typepiece)) {
                        $arr['types'][] = [
                            'id' => $typepiece->id,
                            'nom' => $typepiece->name,
                            'montant' => $typepiece->montant,
                            'is_qualirepar' => $typepiece->is_qualirepar,
                            'prix_initial' => $type['prix_initial'],
                            'prix_promo' => $type['prix_promo'],
                            //'remise' => $type['remise'],
                            'afficher' => $type['afficher'],
                        ];
                    }

                }
            }
            $pannesAvecTypes[] = $arr;
        }

        return response()->json([
            'pannes' => $pannesAvecTypes,
            'prixRachat' => $prixRachat,
            'capacites' => array_keys($prixRachat['bon']),
            'pieces' => ['Bon etat', 'Mauvaise etat', 'Pièce'],
        ]);
    }

    public function SendDataDemandes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'boutiqueId' => 'required|integer|exists:boutiques,id',
            'mode' => 'required|string',
            'device' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'model_id' => 'required|integer',
            'repairs' => 'required|array',
            'repairs.*.id' => 'required|integer',
            'repairs.*.name' => 'required|string',
            'repairs.*.price' => 'nullable|numeric|min:0',
            'client' => 'required|array',
            'client.nom' => 'required|string|max:255',
            'client.prenom' => 'required|string|max:255',
            'client.tel' => 'required|string|max:20',
            'client.email' => 'nullable|email|max:255',
            'client.adresse' => 'nullable|string|max:255',
            'client.notes' => 'nullable|string',
            'appointment' => 'nullable|array',
            'appointment.date' => 'nullable|date_format:Y-m-d',
            'appointment.time' => 'nullable|date_format:H:i',
            'appointment.slot' => 'nullable|string',
            'totalPrice' => 'required|numeric|min:0',
            'etatRachat' => 'nullable|string|in:bon,mauvais,piece',
            'capacites' => 'nullable|array',
            'prixRachat' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        $boutique = Boutique::findOrFail($request->boutiqueId);
        try {
            $clientData = [
                'boutique_id' => $boutique->id,
                'nom' => @$request->client['nom'],
                'prenom' => $request->client['prenom'],
                'telephone' => $request->client['tel'],
                'email' => $request->client['email'] ?? null,
                'adresse' => @$request->client['adresse'] ? Str::substr(@$request->client['adresse'], 0, 10) : null,
            ];

            $client = Client::firstOrCreate(
                ['telephone' => $clientData['telephone']],
                $clientData
            );

            $typeDemande = $request->mode === 'Devis' ? 1 : 0;
            $prefix = $typeDemande === 1 ? 'dev' : 'rdv';
            $year = now()->format('Y');

            $count = Demande::where('boutique_id', $boutique->id)->where('type', $typeDemande)
                ->whereYear('created_at', $year)
                ->count() + 1;

            $numero = str_pad($count, 3, '0', STR_PAD_LEFT);
            $numero_devis = "{$prefix}-{$numero}-{$year}";

            $dateRdv = null;
            if (! empty($request->appointment) && $typeDemande != 1) {
                $dateRdv = @$request->appointment['date'].' '.(@$request->appointment['slot'] ?? @$request->appointment['time']);
            }

            $demandeData = [
                'numero_devis' => $numero_devis,
                'boutique_id' => $boutique->id,
                'modele_id' => $request->model_id,
                'client_id' => $client->id,
                'statut_id' => 1,
                'pannes' => $request->repairs ?? null,
                'type' => $typeDemande,
                'date_rendez_vous' => $dateRdv,
                'is_deleted' => false,
                'notes' => @$request->client['notes'] ?? null,
                'total_price' => $request->totalPrice,
                'repair_options' => @$request->appointment['option'],
                'magazin' => @$request->appointment['address']['address'],
                'is_qualirepair' => (@$request->appointment['address']['is_qualirepar'])?1:0,
                'produit_additionnel' => @$request->selectedProduct,
            ];

            $demande = Demande::create($demandeData);

            Mail::to($demande->client->email)->send(new GenericDemandeEmail($demande, $demande->boutique, true));
            
            Mail::to($demande->boutique->user->email)->send(new GenericDemandeEmail($demande, $demande->boutique, false));

            Notification::create([
                'boutique_id' => null,
                'type' => NotificationType::NOUVELLE_DEMANDE,
                'message' => "Une nouvelle demande a été reçue de la boutique : {$boutique->nom_boutique}.",
            ]);

            Notification::create([
                'boutique_id' => $boutique->id,
                'type' => NotificationType::NOUVELLE_DEMANDE,
                'message' => 'Votre boutique reçu une nouvelle demande client.',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Demande créée avec succès',
                'demande_id' => $demande->id,
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la demande: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Une erreur est survenue lors de la création de la demande.',
            ], 500);
        }
    }

    public function GetBoutiqueAdresses($boutique_id)
    {
        $boutique = Boutique::findOrFail($boutique_id);
        $addresses = $boutique->adresse ?? [];

        return response()->json([
            'success' => true,
            'addresses' => $addresses,
            'remise_online' => $boutique->remise_online ?? 0,
            'reparation_magazin' => $boutique->reparation_magazin ?? false,
            'reparation_magazin_price' => $boutique->reparation_magazin_price ?? 0,
            'reparation_magazin_description' => $boutique->reparation_magazin_description ?? '',
            'reparation_domicile' => $boutique->reparation_domicile ?? false,
            'reparation_domicile_price' => $boutique->reparation_domicile_price ?? 0,
            'reparation_domicile_description' => $boutique->reparation_domicile_description ?? '',
            'reparation_correspondance' => $boutique->reparation_correspondance ?? false,
            'reparation_correspondance_price' => $boutique->reparation_correspondance_price ?? 0,
            'reparation_correspondance_description' => $boutique->reparation_correspondance_description ?? '',
        ]);
    }

    public function BoutiqueTimeDisponible(Request $request, $boutique_id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $date = Carbon::parse($request->input('date'));
        $dayName = $date->format('l');

        $boutique = Boutique::findOrFail($boutique_id);

        $isDayOff = Dayoff::where('boutique_id', $boutique_id)
            ->whereDate('jour_conge', $date)
            ->exists();

        if ($isDayOff) {
            return response()->json([
                'message' => 'La boutique est en congé ce jour-là.',
                'available_times' => [],
                'day' => ucfirst($dayName),
                'is_open' => false,
                'is_dayoff' => true,
            ], 200);
        }

        $dayData = $boutique->$dayName;

        if (is_string($dayData)) {
            $dayData = json_decode($dayData, true);
        }

        if (! $dayData || (isset($dayData['is_open']) && $dayData['is_open'] == '0')) {
            return response()->json([
                'message' => 'La boutique n’est pas ouverte ce jour-là.',
                'available_times' => [],
                'day' => ucfirst($dayName),
                'is_open' => false,
                'is_dayoff' => false,
            ], 200);
        }

        $morningStart = $dayData['midi_debut'] ?? null;
        $morningEnd = $dayData['midi_fin'] ?? null;
        $afternoonStart = $dayData['apres_midi_debut'] ?? null;
        $afternoonEnd = $dayData['apres_midi_fin'] ?? null;

        $existingAppointments = Demande::where('boutique_id', $boutique_id)
            ->whereDate('date_rendez_vous', $date)
            ->where('is_deleted', false)
            ->pluck('date_rendez_vous')
            ->map(fn ($dt) => Carbon::parse($dt)->format('H:i'))
            ->toArray();

        $availableTimes = [];

        foreach ([[$morningStart, $morningEnd], [$afternoonStart, $afternoonEnd]] as [$start, $end]) {
            if ($start && $end) {
                $current = Carbon::parse($start);
                $endTime = Carbon::parse($end);

                while ($current < $endTime) {
                    $slot = $current->format('H:i');
                    if (! in_array($slot, $existingAppointments)) {
                        $availableTimes[] = $slot;
                    }
                    $current->addMinutes(30);
                }
            }
        }

        return response()->json([
            'message' => 'Créneaux horaires disponibles récupérés avec succès.',
            'available_times' => $availableTimes,
            'day' => ucfirst($dayName),
            'is_open' => true,
            'is_dayoff' => false,
        ]);
    }
}
