<?php

namespace App\Http\Controllers\boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();
        return view('boutique.profile.index', ['attributes' => $boutique->toArray()]);
    }



    // Mettre à jour les détails de la boutique
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'siret' => 'required|string|max:14',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'primary_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();
        $boutique->update([
            'nom_boutique' => $request->shop_name,
            'company' => $request->company,
            'telephone' => $request->phone,
            'siret' => $request->siret,
            'city' => $request->city,
            'code_postal' => $request->postal_code,
            'primary_color' => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'libelle' => $request->has('qualirepar') && $request->input('qualirepar') === true ?? false,
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Détails mis à jour avec succès']);
    }

    // Mettre à jour les horaires
    public function updateSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule' => 'required|array',
            'schedule.*.morning.start' => 'nullable|date_format:H:i',
            'schedule.*.morning.end' => 'nullable|date_format:H:i',
            'schedule.*.afternoon.start' => 'nullable|date_format:H:i',
            'schedule.*.afternoon.end' => 'nullable|date_format:H:i',
        ], [
            'schedule.*.morning.start.date_format' => 'Le format doit être HH:MM (ex. 09:30).',
            'schedule.*.morning.end.date_format' => 'Le format doit être HH:MM (ex. 12:00).',
            'schedule.*.afternoon.start.date_format' => 'Le format doit être HH:MM (ex. 14:00).',
            'schedule.*.afternoon.end.date_format' => 'Le format doit être HH:MM (ex. 18:00).',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();
        $days = [
            'lundi' => 'Monday',
            'mardi' => 'Tuesday',
            'mercredi' => 'Wednesday',
            'jeudi' => 'Thursday',
            'vendredi' => 'Friday',
            'samedi' => 'Saturday',
            'dimanche' => 'Sunday'
        ];

        foreach ($days as $frenchDay => $englishDay) {
            $schedule = $request->schedule[$frenchDay];
            $isOpen = !empty($schedule['morning']['start']) && !empty($schedule['afternoon']['end']);
            $boutique->$englishDay = ([
                'midi_debut' => $isOpen ? $schedule['morning']['start'] : null,
                'midi_fin' => $isOpen ? $schedule['morning']['end'] : null,
                'apres_midi_debut' => $isOpen ? $schedule['afternoon']['start'] : null,
                'apres_midi_fin' => $isOpen ? $schedule['afternoon']['end'] : null,
                'is_open' => $isOpen ? 1 : 0,
            ]);
        }

        $boutique->updated_at = now();
        $boutique->save();

        return response()->json(['message' => 'Horaires mis à jour avec succès']);
    }
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'L\'ancien mot de passe est incorrect'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Mot de passe changé avec succès']);
    }
}
