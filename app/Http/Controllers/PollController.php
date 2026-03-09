<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    /**
     * Affiche la liste des sondages.
     */
    public function index()
    {
        $polls = Poll::latest()->get();
        return view('polls.index', compact('polls'));
    }

    /**
     * Affiche le formulaire de création de sondage (Admin uniquement).
     */
    public function create()
    {
        // Vérification de sécurité pour l'admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Action non autorisée.');
        }
        return view('polls.create');
    }

    /**
     * Enregistre un nouveau sondage dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
        ]);

        Poll::create([
            'title' => $request->title,
            'description' => $request->description,
            'options' => $request->options, // Casté automatiquement en JSON via le modèle Poll
            'is_active' => true,
        ]);

        return redirect()->route('polls.index')->with('success', 'Sondage publié avec succès !');
    }

    /**
     * Gère l'enregistrement du vote d'un utilisateur.
     */
    public function vote(Request $request, Poll $poll)
    {
        $request->validate([
            'choice' => 'required|string',
        ]);

        // Vérification si l'utilisateur a déjà voté via la méthode du modèle
        if ($poll->hasVoted(auth()->id())) {
            return back()->with('error', 'Vous avez déjà voté pour ce sondage.');
        }

        // Création du vote dans la table 'votes'
        Vote::create([
            'poll_id' => $poll->id,
            'user_id' => auth()->id(),
            'choice' => $request->choice,
        ]);

        return back()->with('success', 'Votre vote a été pris en compte.');
    }

    /**
     * Affiche les résultats détaillés d'un sondage.
     */
    public function results(Poll $poll)
    {
        // Récupérer tous les votes liés à ce sondage
        $votes = Vote::where('poll_id', $poll->id)->get();
        $totalVotes = $votes->count();

        // Calcul des statistiques par option
        $stats = [];
        if ($poll->options) {
            foreach ($poll->options as $option) {
                $count = $votes->where('choice', $option)->count();
                $percentage = $totalVotes > 0 ? ($count / $totalVotes) * 100 : 0;
                
                $stats[] = [
                    'option' => $option,
                    'count' => $count,
                    'percentage' => round($percentage, 1)
                ];
            }
        }

        return view('polls.results', compact('poll', 'stats', 'totalVotes'));
    }

    /**
     * Affiche un sondage spécifique ou redirige vers les résultats si déjà voté.
     */
    public function show(Poll $poll)
    {
        if ($poll->hasVoted(auth()->id())) {
            return redirect()->route('polls.results', $poll);
        }
        return view('polls.show', compact('poll'));
    }

    /**
     * Permet à l'admin de clôturer un sondage.
     */
    public function toggleStatus(Poll $poll)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $poll->update(['is_active' => !$poll->is_active]);

        return back()->with('success', 'Le statut du sondage a été mis à jour.');
    }
}