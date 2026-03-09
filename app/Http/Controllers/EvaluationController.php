<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Evaluation;
use App\Models\Attendance;
use App\Models\Task;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EvaluationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';

        $evaluations = $isAdmin 
            ? Evaluation::with('user')->latest()->get() 
            : Evaluation::where('user_id', $user->id)->latest()->get();

        $users = $isAdmin ? User::where('role', '!=', 'admin')->get() : collect();
        
        $globalAverage = $evaluations->avg('total_score') ?? 0;
        $totalEvals = $evaluations->count();

        return view('evaluations.index', compact('evaluations', 'users', 'globalAverage', 'totalEvals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $userId = $request->user_id;

        // --- 1. CALCUL DE L'ASSIDUITÉ ---
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->startOfWeek()->addDays(4)->setTime(17, 0, 0);

        $daysPresent = Attendance::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DATE(created_at) as date'))
            ->distinct()
            ->count();
        
        $attendanceScore = ($daysPresent >= 3) ? 4.0 : ($daysPresent / 3) * 4;

        // --- 2. PERFORMANCE TÂCHES ---
        $tasks = Task::where('user_id', $userId)->get();
        $tasksCount = $tasks->count();
        
        if ($tasksCount > 0) {
            $averageProgress = $tasks->avg('progress') / 100; 
            $taskRate = $averageProgress * 4; 
        } else {
            $taskRate = 2.0; 
        }

        // --- 3. ENGAGEMENT SONDAGES (CORRECTION DU NOM DE LA TABLE) ---
        $totalPolls = Poll::count();
        // On utilise la table 'votes' qui est celle créée par ton modèle Vote
        $userVotes = DB::table('votes')->where('user_id', $userId)->count(); 
        $engagementRate = $totalPolls > 0 ? ($userVotes / $totalPolls) * 4 : 2.0;

        // --- 4. MAPPING DES CRITÈRES ---
        $scores = [
            'user_id'             => $userId,
            'problem_solving'     => $taskRate,
            'reporting'           => min(4, $taskRate * 1.1),
            'goals_respect'       => $taskRate,
            'schedule_respect'    => $attendanceScore,
            'presence'            => $attendanceScore,
            'implication'         => $engagementRate,
            'collaboration'       => ($engagementRate + $taskRate) / 2,
            'rules_respect'       => ($daysPresent >= 3) ? 4.0 : 1.5,
            'pressure_management' => 3.0,
            'communication'       => 3.0,
        ];

        // --- 5. CALCUL FINAL PONDÉRÉ / 9 ---
        $weights = [
            'problem_solving'     => 2 / 4,    
            'reporting'           => 2 / 4,    
            'pressure_management' => 1 / 4,    
            'rules_respect'       => 1 / 4,    
            'schedule_respect'    => 0.75 / 4, 
            'communication'       => 0.75 / 4, 
            'goals_respect'       => 0.5 / 4,  
            'implication'         => 0.5 / 4,  
            'presence'            => 0.25 / 4, 
            'collaboration'       => 0.25 / 4, 
        ];

        $total = 0;
        foreach ($weights as $key => $factor) {
            $total += ($scores[$key] ?? 0) * $factor;
        }

        Evaluation::create(array_merge($scores, [
            'total_score' => round($total, 2)
        ]));

        return back()->with('success', "Audit généré avec succès. Score final : " . number_format($total, 2) . "/9");
    }
}