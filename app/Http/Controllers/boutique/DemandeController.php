<?php

namespace App\Http\Controllers\boutique;

use App\Enums\NotificationType;
use App\Http\Controllers\Controller;
use App\Mail\GenericDemandeEmail;
use App\Models\Boutique;
use App\Models\Demande;
use App\Models\Notification;
use App\Models\Statut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();
        $typeMap = [
            'Rendez-vous' => 0,
            'Devis' => 1,
        ];
        $config_type = $boutique->config_type ?? 'Rendez-vous';
        $typeValue = $typeMap[$config_type] ?? 0;
        $demandes = Demande::where('type', $typeValue)
            ->with(['client', 'statut'])
            ->latest()
            ->get();
        $statuts = Statut::where('is_statut', $typeValue)->get();

        Notification::where('boutique_id', $boutique->id)
            ->where('type', NotificationType::NOUVELLE_DEMANDE)
            ->where('is_oppen', 0)
            ->update(['is_oppen' => 1]);
        return view('boutique.demandes.index', compact(
            'demandes',
            'statuts',
            'config_type'
        ));
    }
    public function show($id)
    {
        $demande = Demande::findOrFail($id);
        return response()->json([
            'demande' => $demande
        ]);
    }


    public function SendAndUpdateData(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);

        $demande->date_rendez_vous = $request->date_rendez_vous ?? null;
        $demande->statut_id = 2;
        $demande->global_remise = $request->global_remise ?? 0;
        $demande->commentaire = $request->commentaire ?? '';

        if($demande->type == 1){
            $prices = $request->pannes;

            $pannes = $demande->pannes ?? [];
            foreach($pannes as $key => $panne){
                
                $pannes[$key]['price'] = $prices[$key];
                $pannes[$key]['type']['prix_initial'] = $prices[$key];
                $pannes[$key]['type']['prix_promo'] = 0;
                
            }
            $demande->pannes = $pannes;
        }
       // $pannes = $request->pannes ?? [];

        // $pivotData = [];
        // foreach ($pannes as $panne) {
        //     $cleanName = $panne['name'] ?? '';
        //     $cleanType = $panne['type'] ?? '';

        //     $pivotData[] = [
        //         'name' => $cleanName,
        //         'type' => $cleanType,
        //         'price' => $panne['price'] ?? 0,
        //         'remise' => $panne['remise'] ?? 0,
        //     ];
        // }


        // $demande->pannes = $pivotData;
        $demande->save();

        $clientEmail = $demande->client->email ?? 'contact@modelitech.com';
        try {
            $boutique = Boutique::where('id', $demande->boutique_id)->firstOrFail();
            Mail::to($clientEmail)->send(new GenericDemandeEmail($demande, $boutique, true));
            
           
        } catch (\Exception $e) {
            \Log::error('Échec de l\'envoi de l\'e-mail : ' . $e->getMessage());
            return response()->json([
                'message' => 'Demande mise à jour mais échec de l\'envoi de l\'e-mail',
                'demande' => $demande,
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Demande mise à jour avec succès et e-mail envoyé avec le devis en pièce jointe',
            'demande' => $demande, 
        ]);
    }
    public function destroy($id)
    {
        $demande = Demande::find($id);
        if (!$demande) {
            return response()->json(['message' => 'Demande introuvable'], 404);
        }
        $demande->delete();
        return response()->json(['message' => 'Demande supprimée avec succès.']);
    }

}
