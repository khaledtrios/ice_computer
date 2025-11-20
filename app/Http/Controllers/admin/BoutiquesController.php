<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoutiqueRequest;
use App\Jobs\ActivationDesctivationJob;
use App\Mail\BoutiqueInscriptionMail;
use App\Mail\BoutiqueStatusChanged;
use App\Models\Boutique;
use App\Models\ConfigurationBoutique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Enums\NotificationType;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class BoutiquesController extends Controller
{


    public function index()
    {
        Notification::where('boutique_id', null)
            ->where('is_oppen', 0)
            ->update(['is_oppen' => 1]);

        return view('admin.boutiques.index');
    }

    public function store(BoutiqueRequest $request)
    {
        DB::beginTransaction();

        try {
            $plainPassword = $request->password ?? Str::random(10);
            $hashedPassword = Hash::make($plainPassword);
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $hashedPassword,
                'approved' => false,
            ]);

            $user->assignRole('boutique');


            $boutique = Boutique::create([
                'user_id' => $user->id,
                'nom_boutique' => $request->nom_boutique,
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'city' => $request->city,
                'code_postal' => $request->code_postal,
                'siret' => $request->siret,
                'company' => $request->company,
                'config_type' => null,
                'types_par_panne' => [
                    ['type' => 'compatible'],
                    ['type' => 'originale'],
                ],
                'Monday' => ['lundi' => 1, 'midi_debut' => '08:00', 'midi_fin' => '12:00', 'apres_midi_debut' => '14:00', 'apres_midi_fin' => '18:00'],
                'Tuesday' => ['mardi' => 1, 'midi_debut' => '08:00', 'midi_fin' => '12:00', 'apres_midi_debut' => '14:00', 'apres_midi_fin' => '18:00'],
                'Wednesday' => ['mercredi' => 1, 'midi_debut' => '08:00', 'midi_fin' => '12:00', 'apres_midi_debut' => '14:00', 'apres_midi_fin' => '18:00'],
                'Thursday' => ['jeudi' => 1, 'midi_debut' => '08:00', 'midi_fin' => '12:00', 'apres_midi_debut' => '14:00', 'apres_midi_fin' => '18:00'],
                'Friday' => ['vendredi' => 1, 'midi_debut' => '08:00', 'midi_fin' => '12:00', 'apres_midi_debut' => '14:00', 'apres_midi_fin' => '18:00'],
                'Saturday' => ['samedi' => 1, 'midi_debut' => '08:00', 'midi_fin' => '12:00', 'apres_midi_debut' => '14:00', 'apres_midi_fin' => '18:00'],
                'Sunday' => ['dimanche' => 1, 'midi_debut' => '08:00', 'midi_fin' => '12:00', 'apres_midi_debut' => '14:00', 'apres_midi_fin' => '18:00'],
            ]);

            Mail::to($user->email)->send(new BoutiqueInscriptionMail($user, $plainPassword));

            $notifications = [
                [
                    'boutique_id' => null,
                    'type' => NotificationType::NOUVELLE_BOUTIQUE,
                    'message' => 'Une nouvelle boutique a été enregistrée : ' . $boutique->nom_boutique,
                ],
                [
                    'boutique_id' => $boutique->id,
                    'type' => NotificationType::COMPTE_VALIDÉ,
                    'message' => 'Votre compte boutique a bien été enregistré. En attente de validation.',
                ],
            ];

            foreach ($notifications as $notif) {
                Notification::create($notif);
            }

            DB::commit();

            return response()->json(['message' => 'Boutique créée avec succès']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur : ' . $e->getMessage()], 500);
        }

    }

    public function edit($id)
    {
        $boutique = Boutique::findOrFail($id);
        $user = User::findOrFail($boutique->user_id);
        return response()->json([
            'boutique' => [
                'id' => $boutique->id,
                'nom_boutique' => $boutique->nom_boutique,
                'slug' => $boutique->slug,
                'telephone' => $boutique->telephone,
                'adresse' => $boutique->adresse,
                'city' => $boutique->city,
                'code_postal' => $boutique->code_postal,
                'siret' => $boutique->siret,
                'company' => $boutique->company,
            ],
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Boutique::findOrFail($id)->user_id,
            'password' => 'nullable|string|min:8',
            'nom_boutique' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'code_postal' => 'nullable|string|max:10',
            'siret' => 'nullable|string|max:14',
            'company' => 'nullable|string|max:255',
        ], [

        ]);

        $boutique = Boutique::findOrFail($id);
        $user = User::findOrFail($boutique->user_id);

        // Update user
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'approved' => $request->has('edit_approved') ? 1 : 0,
        ]);

        dispatch(new ActivationDesctivationJob($user));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }


        $boutique->update([
            'nom_boutique' => $request->nom_boutique,
            'slug' => Str::slug($request->nom_boutique),
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'city' => $request->city,
            'code_postal' => $request->code_postal,
            'siret' => $request->siret,
            'company' => $request->company,

        ]);

        return response()->json(['message' => 'Boutique mise à jour avec succès']);
    }

    public function loginAsBoutique($id)
    {
        if (Auth::check() && Auth::user()->getRoleNames()->first() === "superadmin") {
            $boutique = Boutique::findOrFail($id);
            $user = User::findOrFail($boutique->user_id);
            if ($user) {
                Auth::login($user);
                return response()->json(['message' => 'Connecté en tant que ' . $user->first_name . ' ' . $user->last_name]);
            }
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
        return response()->json(['message' => 'Accès non autorisé'], 403);
    }

    public function resetConfigBoutique($id)
    {
        $boutique = Boutique::findOrFail($id);
        $boutique->config_type = null;
        $boutique->save();

        ConfigurationBoutique::where('boutique_id', $id)->delete();

        Notification::create([
            'boutique_id' => $boutique->id,
            'type' => NotificationType::resinstallerConfiguration,
            'message' => "Votre boutique a reçu une nouvelle demande client.",
        ]);
        return response()->json(['message' => 'Configuration de la boutique réinitialisée avec succès']);
    }


    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:Actif,Inactif'
        ]);

        $newStatus = $request->input('statut');

        $boutique = Boutique::findOrFail($id);
        $user = $boutique->user;

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "Aucun utilisateur associé à cette boutique."
            ], 404);
        }

        $oldStatus = $user->approved ? 'Actif' : 'Inactif';
        $user->approved = ($newStatus === 'Actif');
        $user->save();

        try {
            if ($user->email) {
                Mail::to($user->email)->send(new BoutiqueStatusChanged($boutique, $oldStatus, $newStatus));
            }

            if ($newStatus === 'Actif') {
                Notification::create([
                    'boutique_id' => $boutique->id,
                    'type' => NotificationType::COMPTE_VALIDÉ,
                    'message' => "Votre compte boutique '{$boutique->nom_boutique}' a été validé et activé.",
                ]);
            } else {
                Notification::create([
                    'boutique_id' => $boutique->id,
                    'type' => NotificationType::DESACTIVATION_COMPTE,
                    'message' => "Votre compte boutique '{$boutique->nom_boutique}' a été désactivé par l'administration.",
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Échec de l’envoi d’un email ou d’une notification de statut : ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => "Le statut de la boutique '{$boutique->nom_boutique}' a été mis à jour vers '{$newStatus}'.",
            'data' => $boutique->fresh()
        ]);
    }


    public function destroy($id)
    {
        $boutique = Boutique::findOrFail($id);
        $user = User::findOrFail($boutique->user_id);
        $boutique->delete();
        $user->delete();
        return response()->json(['message' => 'Boutique supprimée avec succès']);
    }
}