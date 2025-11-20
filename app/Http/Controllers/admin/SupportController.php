<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Support;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Enums\NotificationType;


class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boutique = Boutique::where('user_id', Auth::id())->first();

        if ($boutique) {
            Notification::where('boutique_id', $boutique->id)
                ->update(['is_opened' => true]);
        }

        return view('admin.supports.index');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'boutique_id' => 'required|exists:boutiques,id',
                'objet' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            $ticket = Support::create([
                'boutique_id' => $validated['boutique_id'],
                'objet' => $validated['objet'],
                'status' => false,
                'is_oppen' => false,
            ]);

            Message::create([
                'support_id' => $ticket->id,
                'message' => $validated['message'],
                'is_admin' => true,
                'is_read' => false,
            ]);
            Notification::create([
                'boutique_id' => $ticket->boutique_id,
                'type' => NotificationType::NOUVEAU_TICKET,
                'message' => 'Un nouveau ticket a été ouvert : ' . $ticket->objet,
            ]);

            return response()->json([
                'message' => 'Ticket créé avec succès.',
                'ticket' => $ticket,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error in store ticket: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la création du ticket.'], 500);
        }
    }

    public function show($id)
    {
        $ticket = Support::with('boutique')->findOrFail($id);
        if (!is_numeric($id) || $ticket->botuique_id !== Auth::user()->boutique_id) {
            return abort(404, 'Ticket non trouvé ou accès non autorisé.');
        }
        return view('admin.supports.show', ['ticket' => $ticket]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $ticket = Support::with('boutique')->findOrFail($id);
            return response()->json(['ticket' => $ticket], 200);
        } catch (\Exception $e) {
            Log::error('Error in edit ticket: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la récupération du ticket.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $ticket = Support::findOrFail($id);

            $validated = $request->validate([
                'objet' => 'required|string|max:255',
                'status' => 'required|string',
            ]);

            $ticket->update($validated);
            return response()->json([
                'message' => 'Ticket mis à jour avec succès.',
                'ticket' => $ticket,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in update ticket: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la mise à jour du ticket.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ticket = Support::findOrFail($id);

            // Suppression des messages liés
            $ticket->messages()->delete();

            // Suppression du ticket
            $ticket->delete();

            return response()->json(['message' => 'Ticket supprimé avec succès.'], 200);

        } catch (\Exception $e) {
            Log::error('Error in delete ticket: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la suppression du ticket.'], 500);
        }
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'support_id' => 'required|exists:supports,id',
            'message' => 'required|string|max:2000',
        ]);

        try {
            $message = Message::create([
                'support_id' => $request->support_id,
                'message' => $request->message,
                'is_admin' => true, 
                'is_read' => false,
            ]);
            $ticket = Support::findOrFail($request->support_id);
            $ticket->update([
                'status' => true,
                'is_oppen' => true, 
            ]);
            Notification::create([
                'boutique_id' => $ticket->boutique_id,
                'type' => NotificationType::TICKET_REPONDU,
                'message' => 'Un nouveau message a été ajouté au ticket : ' . $ticket->objet,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Message envoyé avec succès',
                'data' => [
                    'created_at' => $message->created_at->format('d/m/Y H:i'),
                    'message' => $message->message,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi du message',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function close($id)
    {
        try {
            $ticket = Support::findOrFail($id);

            // Vérifier si le ticket n'est pas déjà fermé
            if (!$ticket->status) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le ticket est déjà fermé'
                ], 400);
            }

            $ticket->update([
                'status' => false,
                'is_oppen' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ticket fermé avec succès',
                'data' => $ticket
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la fermeture du ticket',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}