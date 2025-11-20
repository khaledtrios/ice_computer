<?php

namespace App\Http\Controllers\boutique;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProduitAdditionnel;
use App\Models\Materiel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Boutique;

class ProduitAdditionnelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matriels = Materiel::where('is_deleted', 0)->orderBy('priorite', 'ASC')->get();
        return view('boutique.produit_additionnels.index', ['matriels' => $matriels]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $boutique = Boutique::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('materiels', 'public');
        }
        $produit = ProduitAdditionnel::create([
            'boutique_id' => $boutique->id,
            'name' => $request->name,
            'description' => $request->description, 
            'materiel_id' => $request->materiel_id, 
            'price' => $request->price, 
            'image' => $image, 
        ]);
 

        return response()->json(['message' => 'Produit additionnel crée avec succès']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $matriels = Materiel::where('is_deleted', 0)->orderBy('priorite', 'ASC')->get();
        $produit = ProduitAdditionnel::findorfail($id);
        return view('boutique.produit_additionnels.edit', compact('produit', 'matriels'))->render();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $boutique = Boutique::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
        ]);
        $produit = ProduitAdditionnel::findorfail($id);
        $image = $produit->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('materiels', 'public');
        }
        $produit->update([ 
            'name' => $request->name,
            'description' => $request->description, 
            'materiel_id' => $request->materiel_id, 
            'price' => $request->price, 
            'image' => $image, 
        ]);
 

        return response()->json(['message' => 'Produit additionnel crée avec succès']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProduitAdditionnel::destroy($id);
        return response()->json(['message' => 'Produit additionnel supprimé avec succès']);
    }
}
