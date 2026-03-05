<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Evaluation;

class EvaluationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $evaluations = Evaluation::with('user')->latest()->get();
            $users = User::where('role', '!=', 'admin')->get();
            $globalAverage = Evaluation::avg('total_score') ?? 0;
            $totalEvals = Evaluation::count();
        } else {
            $evaluations = Evaluation::where('user_id', $user->id)->latest()->get();
            $users = collect();
            $globalAverage = Evaluation::where('user_id', $user->id)->avg('total_score') ?? 0;
            $totalEvals = $evaluations->count();
        }

        return view('evaluations.index', compact('evaluations', 'users', 'globalAverage', 'totalEvals'));
    }

    public function store(Request $request)
    {
        // On valide des paliers (1=Insuffisant, 2=Moyen, 3=Bien, 4=Excellent)
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'problem_solving' => 'required|integer|between:1,4',
            'goals_respect' => 'required|integer|between:1,4',
            'pressure_management' => 'required|integer|between:1,4',
            'implication' => 'required|integer|between:1,4',
            'rules_respect' => 'required|integer|between:1,4',
            'schedule_respect' => 'required|integer|between:1,4',
            'presence' => 'required|integer|between:1,4',
            'collaboration' => 'required|integer|between:1,4',
            'communication' => 'required|integer|between:1,4',
            'reporting' => 'required|integer|between:1,4',
        ]);

        // AUTOMATISATION : Coefficients basés sur tes maxima (Total 9)
        $weights = [
            'problem_solving' => 2 / 4,
            'goals_respect' => 0.5 / 4,
            'pressure_management' => 1 / 4,
            'implication' => 0.5 / 4,
            'rules_respect' => 1 / 4,
            'schedule_respect' => 0.75 / 4,
            'presence' => 0.25 / 4,
            'collaboration' => 0.25 / 4,
            'communication' => 0.75 / 4,
            'reporting' => 2 / 4,
        ];

        $finalScores = ['user_id' => $request->user_id];
        $total = 0;

        foreach ($weights as $criterion => $factor) {
            $scoreValue = $request->$criterion * $factor;
            $finalScores[$criterion] = $scoreValue;
            $total += $scoreValue;
        }

        Evaluation::create(array_merge($finalScores, ['total_score' => $total]));

        return back()->with('success', 'Évaluation générée avec succès ! Note : ' . number_format($total, 2) . '/9');
    }
}