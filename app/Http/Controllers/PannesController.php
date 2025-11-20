<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materiel;
use App\Models\Panne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PannesController extends Controller
{
    public function index()
    {
        $materiels = Materiel::where('is_deleted', false)->get(['id', 'nom_materiel']);
        
        return view('admin.pannes.index', compact('materiels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_panne' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|integer|min:0',
            'materiel_id' => 'required|exists:materiels,id',
        ]);

        try {
            $data = [
                'nom_panne' => $request->nom_panne,
                'description' => $request->description,
                'priorite' => $request->priorite,
                'materiel_id' => $request->materiel_id,
                'is_qualirepar' => ($request->has('is_qualirepar'))?1:0,
                'is_deleted' => false,
            ];

          
            Panne::create($data);

            return response()->json(['message' => 'Panne créée avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Error in storePanne: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la création de la panne'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $panne = Panne::findOrFail($id);
            $panne->image = $panne->image ? Storage::url($panne->image) : null;
            return response()->json(['panne' => $panne]);
        } catch (\Exception $e) {
            Log::error('Error in editPanne: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la récupération de la panne'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_panne' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string',
            'priorite' => 'required|integer|min:0',
            'materiel_id' => 'required|exists:materiels,id',
        ]);

        try {
            $panne = Panne::findOrFail($id);
            $data = [
                'nom_panne' => $request->nom_panne,
                'description' => $request->description,
                'priorite' => $request->priorite,
                'materiel_id' => $request->materiel_id,
                'is_qualirepar' => ($request->has('is_qualirepar'))?1:0,
            ];

            if ($request->hasFile('image')) {
                if ($panne->image) {
                    Storage::disk('public')->delete($panne->image);
                }
                $data['image'] = $request->file('image')->store('pannes', 'public');
            }

            $panne->update($data);

            return response()->json(['message' => 'Panne mise à jour avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Error in updatePanne: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la mise à jour de la panne'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $panne = Panne::findOrFail($id);
            if ($panne->image) {
                Storage::disk('public')->delete($panne->image);
            }
            $panne->delete();
            return response()->json(['message' => 'Panne supprimée avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Error in destroyPanne: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la suppression de la panne'], 500);
        }
    }

    public function show($id)
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

  
}