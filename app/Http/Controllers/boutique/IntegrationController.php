<?php

namespace App\Http\Controllers\boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Domains;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntegrationController extends Controller
{
    public function index()
    {
        $boutique = Boutique::where('user_id', Auth::id())->first();

        if ($boutique) {
            $domain = Domains::where('boutique_id', $boutique->id)->first();

            return view('boutique.integration.index', [
                'domain' => $domain
            ]);
        }

        return view('boutique.integration.index', [
            'domain' => null
        ]);
    }

    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|url|unique:domains,domain_name',
            'width' => 'required|string',
            'height' => 'required|string',
            'iframe_code' => 'nullable|string',
        ], [
            'domain.required' => 'Le champ du domaine est requis.',
            'domain.url' => 'Le domaine doit être une URL valide.',
            'domain.unique' => 'Ce domaine est déjà enregistré.',
            'width.required' => 'Le champ de la largeur est requis.',
            'height.required' => 'Le champ de la hauteur est requis.',
        ]);

        $boutique = Boutique::where('user_id', Auth::id())->firstOrFail();

        Domains::updateOrCreate(
            ['boutique_id' => $boutique->id],
            [
                'domain_name' => $request->domain,
                'width' => $request->width,
                'height' => $request->height,
                'iframe_code' => $request->iframe_code,
                'is_active' => true,
            ]
        );

        return redirect()->back()->with('message', 'domaine ajoute avec succès.');
    }

}

