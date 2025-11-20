<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modele;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
class ModeleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('apple_phones_20251009_132557.json');

        if (!File::exists($path)) {
            $this->command->error("❌ Le fichier JSON n'existe pas : $path");
            return;
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        if ($data === null) {
            $this->command->error("❌ Erreur lors du décodage du JSON !");
            return;
        }

        $insertedCount = 0;
        $tablettesCount = 0;
        $smartphonesCount = 0;

        foreach ($data['phones'] as $phone) {
            try {
                $imageContent = @file_get_contents($phone['image']);
                if ($imageContent === false) {
                    $this->command->warn("⚠️ Impossible de télécharger l'image pour : " . $phone['name']);
                    continue;
                }

                $extension = pathinfo(parse_url($phone['image'], PHP_URL_PATH), PATHINFO_EXTENSION);
                $extension = $extension ?: 'jpg';
                $filename = Str::slug($phone['name']) . '_' . time() . '_' . $insertedCount . '.' . $extension;
                $storagePath = 'modeles/' . $filename;

                Storage::disk('public')->put($storagePath, $imageContent);

                $tabletteKeywords = [
                    'ipad',          // ex : iPad, iPad Pro, iPad Air, iPad Mini
                    'ipad pro',      // gamme haut de gamme
                    'ipad air',      // milieu de gamme
                    'ipad mini',     // format compact
                ];


                // ✅ Vérifie si c’est une tablette
                if (Str::of($phone['name'])->lower()->contains($tabletteKeywords)) {
                    Modele::create([
                        'nom_modele' => $phone['name'],
                        'image' => $storagePath,
                        'marque_id' => 48, // Marque pour tablettes
                        'priorite' => 0,
                        'boutique_id' => null,
                        'is_validate' => true,
                        'is_deleted' => false,
                    ]);

                    $tablettesCount++;
                } else {
                    // ✅ Smartphone par défaut
                    Modele::create([
                        'nom_modele' => $phone['name'],
                        'image' => $storagePath,
                        'marque_id' => 1, // Marque pour smartphones
                        'priorite' => 0,
                        'boutique_id' => null,
                        'is_validate' => true,
                        'is_deleted' => false,
                    ]);

                    $smartphonesCount++;
                }

                $insertedCount++;
            } catch (\Exception $e) {
                $this->command->error("❌ Erreur lors de l'insertion de " . $phone['name'] . " : " . $e->getMessage());
            }
        }

        $this->command->info("✅ $insertedCount modèles insérés avec succès !");
        $this->command->info("📱 Smartphones : $smartphonesCount");
        $this->command->info("💻 Tablettes : $tablettesCount");
        $this->command->info("🗂️ Images stockées dans storage/app/public/modeles/");
    }
}