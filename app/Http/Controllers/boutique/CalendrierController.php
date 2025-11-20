<?php

namespace App\Http\Controllers\boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Dayoff;
use App\Models\Demande;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class CalendrierController extends Controller
{
    public function index()
    {
        return view('boutique.calendrier.index');
    }

    public function getdataCalender()
    {
        try {
            $boutique = Boutique::where('user_id', auth()->id())->first();
            if (!$boutique) {
                Log::warning('Boutique not found for user ID: ' . auth()->id());
                return response()->json(['error' => 'Boutique not found'], 404);
            }

            // Fetch appointments
            $demandes = Demande::where('boutique_id', $boutique->id)
                ->whereNotNull('date_rendez_vous')
                ->where('is_deleted', false)
                ->with(['client', 'modele'])
                ->get()
                ->map(function ($demande) {
                    try {
                        $description = 'No issues specified';
                        if (is_array($demande->pannes)) {
                            $pannes = array_filter($demande->pannes, function ($item) {
                                return is_string($item);
                            });
                            $description = !empty($pannes) ? implode(', ', $pannes) : $description;
                        } elseif (is_string($demande->pannes)) {
                            $description = $demande->pannes;
                        }

                        return [
                            'id' => $demande->id,
                            'title' => 'RDV: ' . ($demande->client ? $demande->client->nom : 'N/A') . ' - ' . ($demande->modele ? $demande->modele->nom_modele : 'N/A'),
                            'start' => Carbon::parse($demande->date_rendez_vous)->toIso8601String(),
                            'end' => Carbon::parse($demande->date_rendez_vous)->addHour()->toIso8601String(),
                            'description' => $description,
                            'color' => '#3788d8',
                            'type' => 'appointment',
                        ];
                    } catch (\Exception $e) {
                        Log::error('Error processing demande ID: ' . $demande->id . ': ' . $e->getMessage());
                        return null;
                    }
                })->filter();

            // Fetch working hours
            $workingDays = [];
            $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            foreach ($daysOfWeek as $index => $day) {
                $dayData = $boutique->$day;
                try {
                    if (is_array($dayData) && isset($dayData['is_open']) && $dayData['is_open'] == 1) {
                        if (
                            isset($dayData['midi_debut'], $dayData['midi_fin']) &&
                            !is_null($dayData['midi_debut']) &&
                            !is_null($dayData['midi_fin']) &&
                            preg_match('/^\d{2}:\d{2}$/', $dayData['midi_debut']) &&
                            preg_match('/^\d{2}:\d{2}$/', $dayData['midi_fin'])
                        ) {
                            $workingDays[] = [
                                'title' => 'Working Hours (Morning)',
                                'startTime' => $dayData['midi_debut'],
                                'endTime' => $dayData['midi_fin'],
                                'daysOfWeek' => [$index],
                                'color' => '#e6f4ea',
                                'display' => 'background',
                                'type' => 'working_hours',
                            ];
                        }

                        if (
                            isset($dayData['apres_midi_debut'], $dayData['apres_midi_fin']) &&
                            !is_null($dayData['apres_midi_debut']) &&
                            !is_null($dayData['apres_midi_fin']) &&
                            preg_match('/^\d{2}:\d{2}$/', $dayData['apres_midi_debut']) &&
                            preg_match('/^\d{2}:\d{2}$/', $dayData['apres_midi_fin'])
                        ) {
                            $workingDays[] = [
                                'title' => 'Working Hours (Afternoon)',
                                'startTime' => $dayData['apres_midi_debut'],
                                'endTime' => $dayData['apres_midi_fin'],
                                'daysOfWeek' => [$index],
                                'color' => '#e6f4ea',
                                'display' => 'background',
                                'type' => 'working_hours',
                            ];
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing working hours for ' . $day . ': ' . $e->getMessage());
                    continue;
                }
            }

            // Fetch closed days
            $closedDays = array_map(function ($index) use ($boutique, $daysOfWeek) {
                return $index;
            }, array_keys(array_filter($daysOfWeek, function ($day) use ($boutique) {
                $dayData = $boutique->$day;
                if (
                    empty($dayData) ||
                    !is_array($dayData) ||
                    !isset($dayData['is_open']) ||
                    $dayData['is_open'] == 0
                ) {
                    return true;
                }
                $hasValidMorning = isset($dayData['midi_debut'], $dayData['midi_fin']) &&
                    !is_null($dayData['midi_debut']) &&
                    !is_null($dayData['midi_fin']) &&
                    preg_match('/^\d{2}:\d{2}$/', $dayData['midi_debut']) &&
                    preg_match('/^\d{2}:\d{2}$/', $dayData['midi_fin']);
                $hasValidAfternoon = isset($dayData['apres_midi_debut'], $dayData['apres_midi_fin']) &&
                    !is_null($dayData['apres_midi_debut']) &&
                    !is_null($dayData['apres_midi_fin']) &&
                    preg_match('/^\d{2}:\d{2}$/', $dayData['apres_midi_debut']) &&
                    preg_match('/^\d{2}:\d{2}$/', $dayData['apres_midi_fin']);
                return !$hasValidMorning && !$hasValidAfternoon;
            })));

            // Fetch day-offs
            $dayoffs = Dayoff::where('boutique_id', $boutique->id)
                ->whereNull('deleted_at')
                ->get()
                ->map(function ($dayoff) {
                    return [
                        'title' => 'Jour de Congé',
                        'start' => Carbon::parse($dayoff->jour_conge)->toIso8601String(),
                        'allDay' => true,
                        'color' => '#dc3545',
                        'type' => 'dayoff',
                    ];
                });

            return response()->json([
                'appointments' => $demandes->toArray(),
                'workingHours' => $workingDays,
                'closedDays' => $closedDays,
                'dayoffs' => $dayoffs->toArray(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getdataCalender: ' . $e->getMessage() . ' | Stack: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Server error occurred'], 500);
        }
    }

    public function storeDayoff(Request $request)
    {
        try {
            $request->validate([
                'jour_conge' => 'required|date'
            ]);

            $boutique = Boutique::where('user_id', auth()->id())->first();
            if (!$boutique) {
                return response()->json(['success' => false, 'message' => 'Boutique not found'], 404);
            }

            $dayoff = Dayoff::create([
                'boutique_id' => $boutique->id,
                'jour_conge' => Carbon::parse($request->jour_conge),
            ]);

            return response()->json(['success' => true, 'message' => 'Jour de congé ajouté']);
        } catch (\Exception $e) {
            Log::error('Error in storeDayoff: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'ajout'], 500);
        }
    }

    public function checkDayoff(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date'
            ]);

            $boutique = Boutique::where('user_id', auth()->id())->first();
            if (!$boutique) {
                return response()->json(['success' => false, 'message' => 'Boutique not found'], 404);
            }

            $isDayoff = Dayoff::where('boutique_id', $boutique->id)
                ->whereDate('jour_conge', Carbon::parse($request->date))
                ->whereNull('deleted_at')
                ->exists();

            return response()->json(['success' => true, 'isDayoff' => $isDayoff]);
        } catch (\Exception $e) {
            Log::error('Error in checkDayoff: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur lors de la vérification'], 500);
        }
    }

    public function destroyDayoff(Request $request)
    {
        try {
            $request->validate([
                'jour_conge' => 'required|date'
            ]);

            $boutique = Boutique::where('user_id', auth()->id())->first();
            if (!$boutique) {
                return response()->json(['success' => false, 'message' => 'Boutique not found'], 404);
            }

            $dayoff = Dayoff::where('boutique_id', $boutique->id)
                ->whereDate('jour_conge', Carbon::parse($request->jour_conge))
                ->whereNull('deleted_at')
                ->first();

            if ($dayoff) {
                $dayoff->delete();
                return response()->json(['success' => true, 'message' => 'Jour de congé supprimé']);
            }

            return response()->json(['success' => false, 'message' => 'Jour de congé non trouvé'], 404);
        } catch (\Exception $e) {
            Log::error('Error in destroyDayoff: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
        }
    }
}