<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        // 1. On récupère le pointage du jour
        $attendance = Attendance::where('user_id', $userId)
                                ->whereDate('date', $today)
                                ->first();

        // 2. On calcule le nombre de jours validés cette semaine
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $completedDaysCount = Attendance::where('user_id', $userId)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->where('is_completed', true)
            ->count();

        // 3. On envoie les DEUX variables à la vue
        return view('attendances.index', compact('attendance', 'completedDaysCount'));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $today = Carbon::today();
            $step = $request->step;

            $attendance = Attendance::firstOrCreate(
                ['user_id' => $user->id, 'date' => $today]
            );

            // On utilise now() mais on s'assure que Laravel le traite comme une date
            $attendance->$step = now(); 

            if ($step == 'check_out_17h00') {
                $attendance->is_completed = true;
            }

            $attendance->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Cela permet de voir l'erreur réelle dans l'onglet "Network" de ton navigateur (F12)
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}