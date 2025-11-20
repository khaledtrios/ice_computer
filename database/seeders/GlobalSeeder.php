<?php

namespace Database\Seeders;

use App\Models\Boutique;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class GlobalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
    {
        // Créer les rôles
        foreach (['superadmin', 'boutique'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Création du Superadmin
        $superadmin = User::create([
            'first_name' => 'superadmin',
            'last_name' => 'admin',
            'email' => 'superadmin@model-itech.fr',
            'password' => Hash::make('20202020'),
            'approved' => true,
        ]);
        $superadmin->assignRole('superadmin');

        // Création d’un utilisateur boutique
        $boutiqueUser = User::create([
            'first_name' => 'admin',
            'last_name' => 'boutique1',
            'email' => 'boutique1@model-itech.fr',
            'password' => Hash::make('20202020'),
            'approved' => true,
        ]);
        $boutiqueUser->assignRole('boutique');

        // Création de sa boutique avec tous les attributs
        Boutique::create([
            'user_id' => $boutiqueUser->id,
            'slug' => 'boutique-' . $boutiqueUser->id,
            'hosts' => json_encode(['model-itech.fr']),
            'config_type' => 'default',

            'nom_boutique' => 'Tech Boutique Paris',
            'telephone' => '0102030405',
            'adresse' => json_encode(['rue' => '1 rue de Paris', 'ville' => 'Paris']),
            'city' => 'Paris',
            'company' => 'TechCorp SARL',
            'code_postal' => '75001',
            'siret' => 12345678901234,
            'libalise' => 1,

            'Monday' => json_encode(['open' => '09:00', 'close' => '18:00']),
            'Tuesday' => json_encode(['open' => '09:00', 'close' => '18:00']),
            'Wednesday' => json_encode(['open' => '09:00', 'close' => '18:00']),
            'Thursday' => json_encode(['open' => '09:00', 'close' => '18:00']),
            'Friday' => json_encode(['open' => '09:00', 'close' => '18:00']),
            'Saturday' => json_encode(['open' => '10:00', 'close' => '14:00']),
            'Sunday' => json_encode(['open' => null, 'close' => null]),

            'is_blocked' => false,

            'reparation_magazin' => 1,
            'reparation_magazin_price' => 49.99,
            'reparation_magazin_description' => 'Réparation rapide et efficace en magasin.',

            'reparation_domicile' => 1,
            'reparation_domicile_price' => 59.99,
            'reparation_domicile_description' => "Intervention rapide à domicile dans toute l'Île-de-France !",

            'reparation_correspondance' => 1,
            'reparation_correspondance_price' => 39.99,
            'reparation_correspondance_description' => 'Réparation par correspondance sous 120 min.',

            'primary_color' => '#123456',
            'secondary_color' => '#abcdef',
        ]);
    }
}
