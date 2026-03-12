<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\AttendanceReminder;

class AttendanceController extends Controller
{
    private $targetLat = 5.365237;
    private $targetLon = -3.957816;
    private $radius = 150; 

    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today();
        $attendance = Attendance::where('user_id', $userId)->whereDate('date', $today)->first();

        // Calcul du quota hebdomadaire (Lundi au Vendredi)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->startOfWeek()->addDays(4);

        $daysPresentCount = Attendance::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek->endOfDay()])
            ->select(DB::raw('DATE(created_at) as date'))
            ->distinct()
            ->count();

        return view('attendances.index', compact('attendance', 'daysPresentCount'));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $step = $request->step;
            $now = Carbon::now();
            
            // Sécurité Week-end
            if ($now->isWeekend()) {
                return response()->json(['success' => false, 'message' => "Le pointage est désactivé le week-end."], 403);
            }

            $config = [
                'check_in_8h30'   => '00:00', 
                'check_out_12h00' => '12:00',
                'check_in_14h00'  => '14:00',
                'check_out_17h00' => '17:00'
            ];

            $minTime = Carbon::today()->setTimeFromTimeString($config[$step]);
            if ($now->lt($minTime)) {
                return response()->json(['success' => false, 'message' => "Trop tôt ! Attendez " . $config[$step]], 403);
            }

            $distance = $this->calculateDistance($request->lat, $request->lng, $this->targetLat, $this->targetLon);
            if ($distance > $this->radius) {
                return response()->json(['success' => false, 'message' => "Hors zone opérationnelle (" . round($distance) . "m)."], 403);
            }

            $attendance = Attendance::firstOrCreate(['user_id' => $user->id, 'date' => Carbon::today()]);
            if ($attendance->$step) return response()->json(['success' => false, 'message' => "Déjà validé."]);

            $attendance->$step = $now;
            $msg = "Pointage réussi à " . $now->format('H:i');

            // Notification de fin de journée
            if ($step == 'check_out_17h00') {
                $attendance->is_completed = true;
                $user->notify(new AttendanceReminder(
                    "✅ Journée terminée ! Vos pointages sont validés.", 
                    route('attendances.index')
                ));

                // Vérification du quota de 3 jours après la fin de la journée
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->startOfWeek()->addDays(4);
                $daysCount = Attendance::where('user_id', $user->id)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek->endOfDay()])
                    ->select(DB::raw('DATE(created_at) as date'))
                    ->distinct()
                    ->count();

                if ($daysCount == 3) {
                    $user->notify(new AttendanceReminder(
                        "🎉 Félicitations ! Quota hebdomadaire atteint (3/5 jours).", 
                        route('attendances.index')
                    ));
                }
            }

            $attendance->save();
            return response()->json(['success' => true, 'message' => $msg]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $r = 6371000; $p = pi() / 180;
        $a = 0.5 - cos(($lat2 - $lat1) * $p) / 2 + cos($lat1 * $p) * cos($lat2 * $p) * (1 - cos(($lon2 - $lon1) * $p)) / 2;
        return 2 * $r * asin(sqrt($a));
    }
}