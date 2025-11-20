<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoutiqueRequest;
use App\Models\Marque;
use App\Models\Boutique;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MaterielsController extends Controller
{
    public function index()
    {
        $marques = Marque::where('is_deleted', false)->get(['id', 'nom_marques']);
        $boutiques = Boutique::get(['id', 'nom_boutique']);
        return view('admin.materiels.index', compact('marques', 'boutiques'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_materiel' => 'required|string|max:255',
            'image' => 'nullable|image',
            'priorite' => 'required|integer|min:0',
            'is_deleted' => 'boolean'
        ]);

        try {
            $data = $request->only([
                'nom_materiel',
                'priorite',
                'is_deleted'
            ]);

            $data['is_deleted'] = $request->boolean('is_deleted', false);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('materiels', 'public');
            }

            Materiel::create($data);

            return response()->json(['message' => 'Matériel créé avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Error in storeMateriel: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la création du matériel: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $materiel = Materiel::findOrFail($id);
            $materiel->image = $materiel->image ? Storage::url($materiel->image) : null;
            return response()->json(['materiel' => $materiel]);
        } catch (\Exception $e) {
            Log::error('Error in editMateriel: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la récupération du matériel'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_materiel' => 'required|string|max:255',
            'image' => 'nullable|image',
            'priorite' => 'required|integer|min:0',
            'is_deleted' => 'boolean'
        ]);

        try {
            $materiel = Materiel::findOrFail($id);
            $data = $request->only([
                'nom_materiel',
                'priorite',
                'is_deleted'
            ]);

            $data['is_deleted'] = $request->boolean('is_deleted', false);

            if ($request->hasFile('image')) {
                if ($materiel->image) {
                    Storage::disk('public')->delete($materiel->image);
                }
                $data['image'] = $request->file('image')->store('materiels', 'public');
            }

            $materiel->update($data);

            return response()->json(['message' => 'Matériel mis à jour avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Error in updateMateriel: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la mise à jour du matériel: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $materiel = Materiel::findOrFail($id);
            if ($materiel->image) {
                Storage::disk('public')->delete($materiel->image);
            }
            $materiel->delete();
            return response()->json(['message' => 'Matériel supprimé avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Error in destroyMateriel: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la suppression du matériel: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }
}