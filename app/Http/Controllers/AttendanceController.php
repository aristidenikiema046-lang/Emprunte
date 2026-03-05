<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Coordonnées cibles (Pharmacie mentionnée dans ton code)
    private $targetLat = 5.365237;
    private $targetLon = -3.957816;
    private $radius = 150; // Rayon de 150 mètres

    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $userId)
                                ->whereDate('date', $today)
                                ->first();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $completedDaysCount = Attendance::where('user_id', $userId)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->where('is_completed', true)
            ->count();

        return view('attendances.index', compact('attendance', 'completedDaysCount'));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $today = Carbon::today();
            $step = $request->step;
            $now = Carbon::now();

            // 1. Validation de la Géolocalisation (Sécurité Serveur)
            $distance = $this->calculateDistance($request->lat, $request->lng, $this->targetLat, $this->targetLon);

            if ($distance > $this->radius) {
                return response()->json([
                    'success' => false, 
                    'message' => "Échec : Vous êtes hors zone (" . round($distance) . "m)."
                ], 403);
            }

            // 2. Enregistrement
            $attendance = Attendance::firstOrCreate(['user_id' => $user->id, 'date' => $today]);

            if ($attendance->$step) {
                return response()->json(['success' => false, 'message' => "Déjà validé."]);
            }

            $attendance->$step = $now;
            $msg = "Pointage réussi à " . $now->format('H:i');

            // Logique de message pour le retard
            if ($step === 'check_in_8h30') {
                $limit = Carbon::today()->setTime(8, 30);
                if ($now->gt($limit->addMinutes(5))) {
                    $msg = "Retard enregistré : " . $now->diffInMinutes($limit) . " min.";
                }
            }

            if ($step == 'check_out_17h00') {
                $attendance->is_completed = true;
            }

            $attendance->save();

            return response()->json(['success' => true, 'message' => $msg]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $r = 6371000; // Rayon de la Terre en mètres
        $p = pi() / 180;
        $a = 0.5 - cos(($lat2 - $lat1) * $p) / 2 + cos($lat1 * $p) * cos($lat2 * $p) * (1 - cos(($lon2 - $lon1) * $p)) / 2;
        return 2 * $r * asin(sqrt($a));
    }
}