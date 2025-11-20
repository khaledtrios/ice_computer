<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MarquesController extends Controller
{
    public function index()
    {
        $matriels = Materiel::where('is_deleted', false)->get(['id', 'nom_materiel']);
        
        return view('admin.marques.index', compact('matriels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_marques' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'priorite' => 'required|integer|min:0',
            'materiel_id' => 'required|exists:materiels,id',
        ]);

        try {
            $data = [
                'nom_marques' => $request->nom_marques,
                'priorite' => $request->priorite,
                'materiel_id' => $request->materiel_id,
                'is_deleted' => false,
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('marques', 'public');
            }

            Marque::create($data);

            return response()->json(['message' => 'Marque créée avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Error in storeMarque: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la création de la marque'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $marque = Marque::findOrFail($id);
            $marque->image = $marque->image ? asset('storage/' . $marque->image) : null;
            return response()->json(['marque' => $marque]);
        } catch (\Exception $e) {
            Log::error('Error in editMarque: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la récupération de la marque'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_marques' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'priorite' => 'required|integer|min:0',
            'materiel_id' => 'required|exists:materiels,id',
        ]);

        try {
            $marque = Marque::findOrFail($id);
            $data = [
                'nom_marques' => $request->nom_marques,
                'priorite' => $request->priorite,
                'materiel_id' => $request->materiel_id,
            ];

            if ($request->hasFile('image')) {
                if ($marque->image) {
                    Storage::disk('public')->delete($marque->image);
                }
                $data['image'] = $request->file('image')->store('marques', 'public');
            }

            $marque->update($data);

            return response()->json(['message' => 'Marque mise à jour avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Error in updateMarque: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la mise à jour de la marque'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $marque = Marque::findOrFail($id);
            if ($marque->image) {
                Storage::disk('public')->delete($marque->image);
            }
            $marque->delete();
            return response()->json(['message' => 'Marque supprimée avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Error in destroyMarque: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la suppression de la marque'], 500);
        }
    }

    public function show($id)
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

  
}