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
        
        // Calcul des statistiques globales
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
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'problem_solving' => 'required|numeric|min:0|max:2',
            'goals_respect' => 'required|numeric|min:0|max:0.5',
            'pressure_management' => 'required|numeric|min:0|max:1',
            'implication' => 'required|numeric|min:0|max:0.5',
            'rules_respect' => 'required|numeric|min:0|max:1',
            'schedule_respect' => 'required|numeric|min:0|max:0.75',
            'presence' => 'required|numeric|min:0|max:0.25',
            'collaboration' => 'required|numeric|min:0|max:0.25',
            'communication' => 'required|numeric|min:0|max:0.75',
            'reporting' => 'required|numeric|min:0|max:2',
        ]);

        // Calcul du total (Somme des notes du tableau $data après l'ID utilisateur)
        $total = array_sum(array_slice($data, 1));

        Evaluation::create(array_merge($data, ['total_score' => $total]));

        return back()->with('success', 'Évaluation enregistrée avec succès ! Note : ' . number_format($total, 2) . '/9');
    }
}