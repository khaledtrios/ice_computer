<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Client;
use App\Models\Domains;
use App\Models\Marque;
use App\Models\Materiel;
use App\Models\Message;
use App\Models\Modele;
use App\Models\Panne;
use App\Models\Support;
use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ProduitAdditionnel;


class AjaxController extends Controller
{
    public function getApiDemande(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $columnIndex = $request->input('order.0.column', 0);
        $columnName = $request->input("columns.$columnIndex.data", 'created_at');
        $columnSortOrder = $request->input('order.0.dir', 'desc');
        $searchValue = $request->input('search.value', '');

        // Colonnes autorisées
        $validColumns = ['id', 'numero_devis', 'created_at', 'date_rendez_vous'];
        $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();

        // ON SÉLECTIONNE TOUTES LES COLONNES NÉCESSAIRES Y COMPRIS 'id' ET 'modele_id'
        $query = Demande::with(['client', 'statut', 'modele.marque.materiel'])
            ->where('boutique_id', $boutique->id)
            ->where('is_deleted', false)
            ->select([
                'id',
                'client_id',
                'statut_id',
                'modele_id',
                'date_rendez_vous',
                'created_at',
                'pannes',
                'numero_devis',
                'global_remise',
                'magazin',
                'repair_options',
                'produit_additionnel',
                'type',
                'commentaire'
            ]);

        // Recherche
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->whereHas('client', function ($q) use ($searchValue) {
                    $q->where('nom', 'like', "%{$searchValue}%")
                        ->orWhere('prenom', 'like', "%{$searchValue}%")
                        ->orWhere('telephone', 'like', "%{$searchValue}%")
                        ->orWhere('email', 'like', "%{$searchValue}%");
                })->orWhere('numero_devis', 'like', "%{$searchValue}%")
                    ->orWhereHas('statut', fn($q) => $q->where('nom_statut', 'like', "%{$searchValue}%"));
            });
        }

        $totalRecords = Demande::where('boutique_id', $boutique->id)
            ->where('is_deleted', false)
            ->count();

        $totalFiltered = (clone $query)->count();

        $demandes = $query->orderBy($columnName, $columnSortOrder)
            ->offset($start)
            ->limit($length)
            ->get();

        $dataArr = $demandes->map(function ($demande) {
            // Sécurité : si modele_id est null ou modèle supprimé type
            $modele = $demande->modele;
            $materiel = $modele?->marque?->materiel?->nom_materiel ?? 'N/A';
            $marque = $modele?->marque?->nom_marques ?? 'N/A';
            $modeleNom = $modele?->nom_modele ?? 'N/A';

            return [
                'id' => $demande->id, // OBLIGATOIRE
                'numero_devis' => $demande->numero_devis ?? 'N/A',
                'nom' => $demande->client->nom ?? '',
                'prenom' => $demande->client->prenom ?? '',
                'telephone' => $demande->client->telephone ?? '',
                'email' => $demande->client->email ?? '',
                'statut' => $demande->statut->nom_statut ?? 'Non vérifié',
                'created_at' => $demande->created_at?->format('d/m/Y'),
                'date_rendez_vous' => $demande->date_rendez_vous,
                'global_remise' => $demande->global_remise ?? 0,
                'commentaire' => $demande->commentaire ?? '',
                'pannes' => is_string($demande->pannes)
                    ? json_decode($demande->pannes, true)
                    : ($demande->pannes ?? []),
                'repair_options' => $demande->repair_options ?? [],
                'produit_additionnel' => $demande->produit_additionnel ?? [],
                'magazin' => $demande->magazin,
                'type' => $demande->type,
                'materiel' => $materiel,
                'marque' => $marque,
                'modele' => $modeleNom,
            ];
        })->toArray();

        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $dataArr,
        ]);
    }
    public function getApiClient(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $rowPerPage = $request->input('length');
        $columnIndexArr = $request->input('order', []);
        $columnNameArr = $request->input('columns', []);
        $orderArr = $request->input('order', []);
        $searchArr = $request->input('search', []);

        $columnIndex = $columnIndexArr[0]['column'] ?? 0;
        $columnName = $columnNameArr[$columnIndex]['data'] ?? 'created_at';
        $columnSortOrder = $orderArr[0]['dir'] ?? 'desc';
        $searchValue = $searchArr['value'] ?? '';

        $validColumns = ['id', 'nom', 'telephone', 'prenom', 'email', 'created_at'];
        $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();

        $query = Client::where('boutique_id', $boutique->id)
            ->where('id', '!=', Auth::id())
            ->select('id', 'nom', 'telephone', 'prenom', 'email', 'created_at');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('nom', 'like', '%' . $searchValue . '%')
                    ->orWhere('prenom', 'like', '%' . $searchValue . '%')
                    ->orWhere('telephone', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecords = $query->count();

        $clients = $query->orderBy($columnName, $columnSortOrder)
            ->offset($start)
            ->limit($rowPerPage)
            ->get();

        $dataArr = $clients->map(function ($client) {
            return [
                'id' => $client->id,
                'nom' => $client->nom,
                'prenom' => $client->prenom,
                'email' => $client->email,
                'telephone' => $client->telephone ?? 'N/A',
                'adresse' => $client->adresse ?? 'N/A',
                'total_demandes' => $client->demande()->count(),
                'created_at' => $client->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $dataArr,
        ], 200);
    }
    
    public function getApiTickets(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $rowPerPage = $request->input('length');
        $columnIndex = $request->input('order.0.column', 0);
        $columnName = $request->input("columns.$columnIndex.data", 'created_at');
        $columnSortOrder = $request->input('order.0.dir', 'desc');
        $searchValue = $request->input('search.value', '');

        $validColumns = ['id', 'objet', 'status', 'created_at'];
        $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

        $user = Auth::user();
        $boutique = Boutique::where('user_id', $user->id)->firstOrFail();

        // Base query
        $query = Support::with('boutique')
            ->select('supports.id', 'supports.boutique_id', 'supports.objet', 'supports.status', 'supports.created_at')
            ->where('supports.boutique_id', $boutique->id);

        // Search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('supports.objet', 'like', '%' . $searchValue . '%')
                    ->orWhere('supports.message', 'like', '%' . $searchValue . '%');
            });
        }

        // Total records
        $totalRecords = $query->count();

        // Fetch paginated and sorted data
        $tickets = $query->orderBy($columnName, $columnSortOrder)
            ->offset($start)
            ->limit($rowPerPage)
            ->get();

        $dataArr = $tickets->map(function ($ticket) {
            $statusText = $ticket->status ? 'Ouvert' : ($ticket->is_open ? 'En cours' : 'Fermé');

            return [
                'id' => $ticket->id,
                'boutique' => $ticket->boutique ? $ticket->boutique->nom_boutique : 'N/A',
                'objet' => $ticket->objet,
                'message' => $ticket->message,
                'status' => $statusText,
                'is_open' => $ticket->is_open ? 'Oui' : 'Non',
                'created_at' => $ticket->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $dataArr,
        ], 200);
    }

    public function getApiProduitAdditionnels(Request $request)
    {
         
        $draw = $request->input('draw');
        $start = $request->input('start');
        $rowPerPage = $request->input('length');
        $columnIndex = $request->input('order.0.column', 0);
        $columnName = $request->input("columns.$columnIndex.data", 'created_at');
        $columnSortOrder = $request->input('order.0.dir', 'desc');
        $searchValue = $request->input('search.value', '');
        $validColumns = ['id', 'name', 'materiel_id', 'price', 'image', 'created_at'];
        $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

        $user = Auth::user();
        $boutique = Boutique::where('user_id', $user->id)->firstOrFail();
        // Base query
        $query = ProduitAdditionnel::where('produit_additionnels.boutique_id', $boutique->id);

        // Search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('produit_additionnels.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('produit_additionnels.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('produit_additionnels.price', 'like', '%' . $searchValue . '%')
                    ;
            });
        }
 
        // Total records
        $totalRecords = $query->count();

        // Fetch paginated and sorted data
        $products = $query->orderBy($columnName, $columnSortOrder)
            ->offset($start)
            ->limit($rowPerPage)
            ->get();

        $dataArr = $products->map(function ($produit) { 
            return [
                'id' => $produit->id,
                'name' => $produit->name,
                'materiel_id' => $produit->materiel->nom_materiel,
                'price' => $produit->price,  
                'image' => asset('storage/'. $produit->image),  
                'created_at' => $produit->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $dataArr,
        ], 200);
    }

    public function getBoutiques(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $rowPerPage = $request->input('length');
        $searchArr = $request->input('search', []);
        $searchValue = $searchArr['value'] ?? '';

        // Base query
        $query = Boutique::with('user')->select('boutiques.*');

        // Filtrage par recherche
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('nom_boutique', 'like', "%{$searchValue}%")
                    ->orWhere('telephone', 'like', "%{$searchValue}%")
                    ->orWhere('adresse->adresse', 'like', "%{$searchValue}%") // pour JSON
                    ->orWhere('city', 'like', "%{$searchValue}%");
            });
        }

        // Nombre total d’enregistrements filtrés
        $totalRecords = $query->count();

        // Récupération avec tri forcé sur created_at DESC
        $boutiques = $query->orderBy('created_at', 'desc')
            ->offset($start)
            ->limit($rowPerPage)
            ->get();

        // Préparation des données pour DataTables
        $dataArr = $boutiques->map(function ($boutique) {
            return [
                'id' => $boutique->id,
                'nom_boutique' => $boutique->nom_boutique ?? 'N/A',
                'city' => $boutique->city ?? 'N/A',
                'code_postal' => $boutique->code_postal ?? 'N/A',
                'siret' => $boutique->siret ?? 'N/A',
                'company' => $boutique->company ?? 'N/A',
                'config_type' => $boutique->config_type ?? 'Non-configuré',
                'statut' => $boutique->user && $boutique->user->approved ? 'Actif' : 'Inactif',
                'created_at' => $boutique->created_at?->format('Y-m-d'),
            ];
        })->toArray();

        // Réponse JSON pour DataTables
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $dataArr,
        ], 200);
    }

    public function getMateriels(Request $request)
    {
        try {
            $draw = $request->input('draw');
            $start = $request->input('start');
            $rowPerPage = $request->input('length');
            $columnIndexArr = $request->input('order', []);
            $columnNameArr = $request->input('columns', []);
            $orderArr = $request->input('order', []);
            $searchArr = $request->input('search', []);

            $columnIndex = $columnIndexArr[0]['column'] ?? 0;
            $columnName = $columnNameArr[$columnIndex]['data'] ?? 'created_at';
            $columnSortOrder = $orderArr[0]['dir'] ?? 'desc';
            $searchValue = $searchArr['value'] ?? '';

            $validColumns = ['id', 'nom_materiel', 'priorite', 'is_deleted', 'created_at'];
            $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

            // Base query
            $query = Materiel::where('is_deleted', false)->select('id', 'nom_materiel', 'image', 'priorite', 'is_deleted', 'created_at');

            // Search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('nom_materiel', 'like', '%' . $searchValue . '%')
                        ->orWhere('priorite', 'like', '%' . $searchValue . '%');
                });
            }

            // Total records
            $totalRecords = $query->count();

            // Fetch paginated and sorted data
            $materiels = $query->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($rowPerPage)
                ->get();

            $dataArr = $materiels->map(function ($materiel) {
                return [
                    'id' => $materiel->id,
                    'nom_materiel' => $materiel->nom_materiel ?? 'N/A',
                    'image' => $materiel->image ? asset('storage/' . $materiel->image) : 'N/A',
                    'priorite' => $materiel->priorite ?? 0,
                    'is_deleted' => $materiel->is_deleted ? 'Supprimé' : 'Actif',
                    'created_at' => $materiel->created_at->format('Y-m-d'),
                ];
            })->toArray();

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $dataArr,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in getMateriels: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getMarques(Request $request)
    {
        try {
            $draw = $request->input('draw', 1);
            $start = $request->input('start', 0);
            $rowPerPage = $request->input('length', 10);
            $columnIndex = $request->input('order.0.column', 0);
            $columnName = $request->input("columns.$columnIndex.data", 'created_at');
            $columnSortOrder = $request->input('order.0.dir', 'desc');
            $searchValue = $request->input('search.value', '');

            $validColumns = ['id', 'nom_marques', 'priorite', 'materiel_id', 'is_deleted', 'created_at'];
            $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

            $materielId = $request->input('materiel_id');

            $baseQuery = Marque::where('is_deleted', false);
            $query = clone $baseQuery;
            $query->with('materiel:id,nom_materiel');

            // Apply filter
            if ($materielId) {
                $baseQuery->where('materiel_id', $materielId);
                $query->where('materiel_id', $materielId);
            }

            $totalRecords = $baseQuery->count();

            // Apply search
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('nom_marques', 'like', "%$searchValue%")
                        ->orWhere('priorite', 'like', "%$searchValue%")
                        ->orWhereHas('materiel', function ($qq) use ($searchValue) {
                            $qq->where('nom_materiel', 'like', "%$searchValue%");
                        });
                });
            }

            $recordsFiltered = (clone $query)->count();

            $marques = $query->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($rowPerPage)
                ->get();

            $dataArr = $marques->map(function ($marque) {
                return [
                    'id' => $marque->id,
                    'nom_marques' => $marque->nom_marques ?? 'N/A',
                    'image' => $marque->image ? asset('storage/' . $marque->image) : 'N/A',
                    'priorite' => $marque->priorite ?? 0,
                    'materiel' => $marque->materiel ? $marque->materiel->nom_materiel : 'N/A',
                    'is_deleted' => $marque->is_deleted ? 'Supprimé' : 'Actif',
                    'created_at' => $marque->created_at?->format('Y-m-d') ?? 'N/A',
                ];
            })->toArray();

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $recordsFiltered,
                'data' => $dataArr,
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        } catch (\Exception $e) {
            \Log::error('Error in getMarques: ' . $e->getMessage());
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    public function getModeles(Request $request)
    {
        try {
            $draw = $request->input('draw', 1);
            $start = $request->input('start', 0);
            $rowPerPage = $request->input('length', 10);
            $columnIndex = $request->input('order.0.column', 0);
            $columnName = $request->input("columns.$columnIndex.data", 'created_at');
            $columnSortOrder = $request->input('order.0.dir', 'desc');
            $searchValue = $request->input('search.value', '');

            $validColumns = ['id', 'nom_modele', 'priorite', 'marque_id', 'boutique_id', 'is_validate', 'created_at'];
            $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

            $materielId = $request->input('materiel_id');
            $marqueId = $request->input('marque_id');

            $baseQuery = Modele::where('is_deleted', false);
            $query = clone $baseQuery;
            $query->with(['marque.materiel:id,nom_materiel', 'boutique:id,nom_boutique']);

            // Apply filters to base and query
            if ($materielId) {
                $baseQuery->whereHas('marque.materiel', function ($q) use ($materielId) {
                    $q->where('id', $materielId);
                });
                $query->whereHas('marque.materiel', function ($q) use ($materielId) {
                    $q->where('id', $materielId);
                });
            }

            if ($marqueId) {
                $baseQuery->where('marque_id', $marqueId);
                $query->where('marque_id', $marqueId);
            }

            $totalRecords = $baseQuery->count();

            // Apply search
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('nom_modele', 'like', "%$searchValue%")
                        ->orWhere('priorite', 'like', "%$searchValue%")
                        ->orWhereHas('marque', function ($qq) use ($searchValue) {
                            $qq->where('nom_marques', 'like', "%$searchValue%");
                        })
                        ->orWhereHas('marque.materiel', function ($qq) use ($searchValue) {
                            $qq->where('nom_materiel', 'like', "%$searchValue%");
                        })
                        ->orWhereHas('boutique', function ($qq) use ($searchValue) {
                            $qq->where('nom_boutique', 'like', "%$searchValue%");
                        });
                });
            }

            $recordsFiltered = (clone $query)->count();

            $modeles = $query->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($rowPerPage)
                ->get();

            $dataArr = $modeles->map(fn($modele) => [
                'id' => $modele->id,
                'nom_modele' => $modele->nom_modele ?? 'N/A',
                'image' => $modele->image ? asset('storage/' . $modele->image) : 'N/A',
                'priorite' => $modele->priorite ?? 0,
                'marque' => $modele->marque?->nom_marques ?? 'N/A',
                'materiel' => $modele->marque?->materiel?->nom_materiel ?? 'N/A',
                'boutique' => $modele->boutique?->nom_boutique ?? 'Créé par l\'équipe model-itech',
                'created_at' => $modele->created_at?->format('Y-m-d') ?? 'N/A',
            ])->toArray();

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $recordsFiltered,
                'data' => $dataArr,
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        } catch (\Exception $e) {
            \Log::error('Error in getModeles: ' . $e->getMessage());
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function getPannes(Request $request)
    {
        try {
            $draw = $request->input('draw', 1);
            $start = $request->input('start', 0);
            $rowPerPage = $request->input('length', 10);
            $columnIndex = $request->input('order.0.column', 0);
            $columnName = $request->input("columns.$columnIndex.data", 'created_at');
            $columnSortOrder = $request->input('order.0.dir', 'desc');
            $searchValue = $request->input('search.value', '');

            $validColumns = ['id', 'nom_panne', 'image', 'description', 'priorite', 'materiel_id', 'created_at'];
            $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

            $materielId = $request->input('materiel_id');

            $baseQuery = Panne::where('is_deleted', false);
            $query = clone $baseQuery;
            $query->with('materiel:id,nom_materiel');

            // Apply filter
            if ($materielId) {
                $baseQuery->where('materiel_id', $materielId);
                $query->where('materiel_id', $materielId);
            }

            $totalRecords = $baseQuery->count();

            // Apply search
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('nom_panne', 'like', "%$searchValue%")
                        ->orWhere('description', 'like', "%$searchValue%")
                        ->orWhere('priorite', 'like', "%$searchValue%")
                        ->orWhereHas('materiel', function ($qq) use ($searchValue) {
                            $qq->where('nom_materiel', 'like', "%$searchValue%");
                        });
                });
            }

            $recordsFiltered = (clone $query)->count();

            $pannes = $query->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($rowPerPage)
                ->get();

            $dataArr = $pannes->map(function ($panne) {
                return [
                    'id' => $panne->id,
                    'nom_panne' => $panne->nom_panne ?? 'N/A',
                    'image' => $panne->image ? asset('storage/' . $panne->image) : 'N/A',
                    'description' => $panne->description ?? 'N/A',
                    'priorite' => $panne->priorite ?? 0,
                    'materiel' => $panne->materiel ? $panne->materiel->nom_materiel : 'N/A',
                    'is_deleted' => $panne->is_deleted ? 'Supprimé' : 'Actif',
                    'created_at' => $panne->created_at?->format('Y-m-d') ?? 'N/A',
                ];
            })->toArray();

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $recordsFiltered,
                'data' => $dataArr,
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        } catch (\Exception $e) {
            \Log::error('Error in getPannes: ' . $e->getMessage());
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    public function getAdminTickets(Request $request)
    {
        try {
            $draw = $request->input('draw');
            $start = $request->input('start');
            $rowPerPage = $request->input('length');
            $columnIndexArr = $request->input('order', []);
            $columnNameArr = $request->input('columns', []);
            $orderArr = $request->input('order', []);
            $searchArr = $request->input('search', []);

            $columnIndex = $columnIndexArr[0]['column'] ?? 0;
            $columnName = $columnNameArr[$columnIndex]['data'] ?? 'created_at';
            $columnSortOrder = $orderArr[0]['dir'] ?? 'desc';
            $searchValue = $searchArr['value'] ?? '';

            $validColumns = ['id', 'boutique_id', 'objet', 'message', 'status', 'is_oppen', 'created_at'];
            $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

            $query = Support::select('supports.id', 'boutique_id', 'objet', 'message', 'image', 'status', 'is_oppen', 'created_at')
                ->with('boutique:id,nom_boutique');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('objet', 'like', '%' . $searchValue . '%')
                        ->orWhere('message', 'like', '%' . $searchValue . '%')
                        ->orWhereHas('boutique', function ($q) use ($searchValue) {
                            $q->where('nom_boutique', 'like', '%' . $searchValue . '%');
                        });
                });
            }

            $totalRecords = $query->count();
            $tickets = $query->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($rowPerPage)
                ->get();

            $dataArr = $tickets->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'boutique' => $ticket->boutique ? $ticket->boutique->nom_boutique : 'N/A',
                    'objet' => $ticket->objet ?? 'N/A',
                    'message' => Str::limit(
                        Message::where('support_id', $ticket->id)
                            ->orderBy('created_at', 'asc')
                            ->first()?->message ?? 'Aucun message',
                        50 // nombre de caractères
                    ),

                    'status' => $ticket->status,
                    'is_oppen' => $ticket->is_oppen,
                    'created_at' => $ticket->created_at->format('Y-m-d'),
                ];
            })->toArray();

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $dataArr,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in getTickets: ' . $e->getMessage());
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    public function getApiDomains(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $rowPerPage = $request->input('length');
        $columnIndexArr = $request->input('order', []);
        $columnNameArr = $request->input('columns', []);
        $orderArr = $request->input('order', []);
        $searchArr = $request->input('search', []);
        $columnIndex = $columnIndexArr[0]['column'] ?? 0;
        $columnName = $columnNameArr[$columnIndex]['data'] ?? 'created_at';
        $columnSortOrder = $orderArr[0]['dir'] ?? 'desc';
        $searchValue = $searchArr['value'] ?? '';

        $validColumns = ['id', 'domain_name', 'width', 'height', 'created_at'];
        $columnName = in_array($columnName, $validColumns) ? $columnName : 'created_at';

        $query = Domains::with('boutique')->select('id', 'boutique_id', 'domain_name', 'width', 'height', 'created_at');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('domain_name', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('boutique', function ($q) use ($searchValue) {
                        $q->where('nom_boutique', 'like', '%' . $searchValue . '%');
                    });
            });
        }

        $totalRecords = $query->count();

        $domains = $query->orderBy($columnName, $columnSortOrder)
            ->offset($start)
            ->limit($rowPerPage)
            ->get();

        $dataArr = $domains->map(function ($domain) {
            return [
                'id' => $domain->id,
                'boutique' => $domain->boutique ? $domain->boutique->nom_boutique : 'N/A',
                'domain_name' => $domain->domain_name,
                'width' => $domain->width,
                'height' => $domain->height ?? 'N/A',
                'created_at' => $domain->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $dataArr,
        ], 200);
    }

}
