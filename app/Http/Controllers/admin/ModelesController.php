<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Marque;
use App\Models\Boutique;
use App\Models\Modele;

class ModelesController extends Controller
{
    public function index()
    {
        $marques = Marque::with('materiel:id,nom_materiel')->where('is_deleted', false)->get();
        $matriels = Materiel::where('is_deleted', false)->get();
        $boutiques = Boutique::get(['id', 'nom_boutique']);
        return view('admin.modeles.index', [
            'marques' => $marques,
            'boutiques' => $boutiques,
            'matriels' => $matriels
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nom_modele' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'priorite' => 'required|integer|min:0',
            'marque_id' => 'required|exists:marques,id',
            'boutique_id' => 'nullable|exists:boutiques,id',
            'is_validate' => 'boolean',
        ]);

        try {
            $data = [
                'nom_modele' => $request->nom_modele,
                'priorite' => $request->priorite,
                'marque_id' => $request->marque_id,
                'boutique_id' => $request->boutique_id,
                'is_validate' => $request->boolean('is_validate', false),
                'is_deleted' => false,
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('modeles', 'public');
            }

            Modele::create($data);

            return response()->json(['message' => 'Modèle créé avec succès'], 200);
        } catch (\Exception $e) {
            \Log::error('Error in storeModele: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la création du modèle: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {

        try {
            $modele = Modele::findOrFail($id);
            if ($modele->image) {
                Storage::disk('public')->delete($modele->image);
            }
            $modele->delete();
            return response()->json(['message' => 'Modèle supprimé avec succès'], 200);
        } catch (\Exception $e) {
            \Log::error('Error in destroyModele: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la suppression du modèle: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $modele = Modele::findOrFail($id);
        $marques = Marque::with('materiel:id,nom_materiel')->where('is_deleted', false)->get();
        $boutiques = Boutique::get(['id', 'nom_boutique']);
        return response()->json(['modele' => $modele, 'marques' => $marques, 'boutiques' => $boutiques]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nom_modele' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'priorite' => 'required|integer|min:0',
            'marque_id' => 'required|exists:marques,id',
            'boutique_id' => 'nullable|exists:boutiques,id',
            'is_validate' => 'boolean',
        ]);

        try {
            $modele = Modele::findOrFail($id);
            $data = [
                'nom_modele' => $request->nom_modele,
                'priorite' => $request->priorite,
                'marque_id' => $request->marque_id,
                'boutique_id' => $request->boutique_id,
                'is_validate' => $request->boolean('is_validate', false),
            ];

            if ($request->hasFile('image')) {
                if ($modele->image) {
                    Storage::disk('public')->delete($modele->image);
                }
                $data['image'] = $request->file('image')->store('modeles', 'public');
            }

            $modele->update($data);

            return response()->json(['message' => 'Modèle mis à jour avec succès'], 200);
        } catch (\Exception $e) {
            \Log::error('Error in updateModele: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la mise à jour du modèle: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

   
}