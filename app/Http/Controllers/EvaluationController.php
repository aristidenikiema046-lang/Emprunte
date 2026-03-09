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
    /**
     * Affiche la liste des évaluations.
     */
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';

        // Récupération des évaluations selon le rôle
        $evaluations = $isAdmin 
            ? Evaluation::with('user')->latest()->get() 
            : Evaluation::where('user_id', $user->id)->latest()->get();

        // Liste des utilisateurs pour le select (Admin uniquement)
        $users = $isAdmin ? User::where('role', '!=', 'admin')->get() : collect();
        
        // Statistiques globales ou personnelles
        $globalAverage = $evaluations->avg('total_score') ?? 0;
        $totalEvals = $evaluations->count();

        return view('evaluations.index', compact('evaluations', 'users', 'globalAverage', 'totalEvals'));
    }

    /**
     * Génère une évaluation automatique (Audit de performance).
     */
    public function store(Request $request)
    {
        // Validation de l'ID utilisateur
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $userId = $request->user_id;

        // --- 1. CALCUL DE L'ASSIDUITÉ (Règle des 3/5 jours par semaine) ---
        // Fenêtre : Du lundi 00:00 au vendredi 17:00 de la semaine en cours
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->startOfWeek()->addDays(4)->setTime(17, 0, 0);

        $daysPresent = Attendance::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DATE(created_at) as date'))
            ->distinct()
            ->count();
        
        // Score présence (Sur une base de 4 points)
        if ($daysPresent >= 3) {
            $attendanceScore = 4.0; 
        } else {
            // Pénalité si moins de 3 jours : score réduit de moitié
            $attendanceScore = ($daysPresent / 3) * 2; 
        }

        // --- 2. PERFORMANCE TÂCHES (Abnégation & Sérieux) ---
        // Basé sur le ratio de tâches complétées (Historique global ou récent)
        $tasksTotal = Task::where('user_id', $userId)->count();
        $tasksDone = Task::where('user_id', $userId)->where('status', 'completed')->count();
        
        // Score tâches (Base 4 points) : 2.0 par défaut si aucune tâche assignée
        $taskRate = $tasksTotal > 0 ? ($tasksDone / $tasksTotal) * 4 : 2.0;

        // --- 3. ENGAGEMENT SONDAGES (Implication dans l'entreprise) ---
        $totalPolls = Poll::count();
        $userVotes = DB::table('poll_votes')->where('user_id', $userId)->count(); 
        
        // Score engagement (Base 4 points)
        $engagementRate = $totalPolls > 0 ? ($userVotes / $totalPolls) * 4 : 2.0;

        // --- 4. MAPPING DES CRITÈRES (Base 4) ---
        $scores = [
            'user_id'             => $userId,
            'problem_solving'     => $taskRate,
            'reporting'           => min(4, $taskRate * 1.1), // Le reporting est boosté par la finition des tâches
            'goals_respect'       => $taskRate,
            'schedule_respect'    => $attendanceScore,
            'presence'            => $attendanceScore,
            'implication'         => $engagementRate,
            'collaboration'       => ($engagementRate + $taskRate) / 2,
            'rules_respect'       => ($daysPresent >= 3) ? 4.0 : 1.5, // Application stricte de la règle 3/5
            'pressure_management' => 3.0, // Valeur neutre par défaut (difficilement automatisable)
            'communication'       => 3.0, // Valeur neutre par défaut
        ];

        // --- 5. CALCUL FINAL PONDÉRÉ (Note sur 9 points) ---
        // Coefficients basés sur tes fichiers précédents
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
            $total += $scores[$key] * $factor;
        }

        // Création de l'évaluation en base de données
        Evaluation::create(array_merge($scores, [
            'total_score' => round($total, 2)
        ]));

        // Retour avec message de succès (pour l'admin en manuel)
        return back()->with('success', "Audit hebdomadaire généré avec succès. Présence validée : $daysPresent/5 jours. Score final : " . number_format($total, 2) . "/9");
    }
}