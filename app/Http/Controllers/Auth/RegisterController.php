<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\BoutiqueRequest;
use App\Jobs\ActivationDesctivationJob;
use App\Mail\BoutiqueInscriptionMail;
use App\Mail\BoutiqueStatusChanged;
use App\Models\Boutique;
use App\Models\ConfigurationBoutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Enums\NotificationType;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //dd($data);
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        //dd($data);
        DB::beginTransaction();

        try {
            $plainPassword = $data['password'] ?? Str::random(10);
            $hashedPassword = Hash::make($plainPassword);
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $hashedPassword,
                'approved' => false,
            ]);

            $user->assignRole('boutique');


            $boutique = Boutique::create([
                'user_id' => $user->id,
                'nom_boutique' => $data['nom_boutique'],
                'telephone' => $data['telephone'],
                'adresse' => $data['adresse'],
                'city' => $data['city'],
                'code_postal' => $data['code_postal'],
                'siret' => $data['siret'],
                'company' => $data['company'],
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
            Mail::to($user->email)->send(new BoutiqueInscriptionMail($user, $plainPassword));

            DB::commit();
            if ($user) {
                Alert::success('Inscription réussie', 'Votre inscription a été soumise. Vous recevrez une réponse par email après acceptation par le support.');
            } else {
                Alert::error('Échec de l\'inscription', 'Une erreur est survenue. Veuillez réessayer.');
            }

            return $user;
            return response()->json(['message' => 'Boutique créée avec succès']);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
            return response()->json(['message' => 'Erreur : ' . $e->getMessage()], 500);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
