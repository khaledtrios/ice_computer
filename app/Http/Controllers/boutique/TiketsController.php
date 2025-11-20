<?php

namespace App\Http\Controllers\boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Support;
use App\Models\Message;

class TiketsController extends Controller
{
    public function index()
    {
        return view('boutique.tikets.index');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $boutique = Boutique::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'objet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $support = Support::create([
            'boutique_id' => $boutique->id,
            'objet' => $request->objet,
            'message' => $request->message,
            'status' => 0,
            'is_open' => 0
        ]);

        Message::create([
            'support_id' => $support->id,
            'message' => $request->message,
            'is_admin' => false,
            'is_read' => false,
        ]);

        return response()->json(['message' => 'Ticket créé avec succès']);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $boutique = Boutique::where('user_id', $user->id)->firstOrFail();
        $ticket = Support::where('boutique_id', $boutique->id)->findOrFail($id);

        $request->validate([
            'objet' => 'nullable|string|max:255',
            'message' => 'required|string',
            'status' => 'nullable|in:Ouvert,En cours,Résolu,Fermé',
        ]);

        $ticket->update([
            'objet' => $request->objet,
            'message' => $request->message,
            'status' => in_array($request->status, ['Ouvert', 'En cours']),
            'is_open' => in_array($request->status, ['Ouvert', 'En cours']),
        ]);

        Message::create([
            'support_id' => $ticket->id,
            'message' => $request->message,
            'is_admin' => false,
            'is_read' => false,
        ]);

        return response()->json(['message' => 'Ticket mis à jour avec succès']);
    }

    public function show($id)
    {
        $user = Auth::user();
        $boutique = Boutique::where('user_id', $user->id)->firstOrFail();
        $ticket = Support::with('messages', 'boutique')
            ->where('boutique_id', $boutique->id)
            ->findOrFail($id);

        return view('boutique.tikets.show', ['ticket' => $ticket]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $boutique = Boutique::where('user_id', $user->id)->firstOrFail();

        $ticket = Support::where('boutique_id', $boutique->id)->findOrFail($id);

        // Supprimer les messages liés
        $ticket->messages()->delete();

        // Ensuite supprimer le support
        $ticket->delete();

        return response()->json(['message' => 'Ticket supprimé avec succès']);
    }



}
