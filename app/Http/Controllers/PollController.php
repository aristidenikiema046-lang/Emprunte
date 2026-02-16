<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    /**
     * Affiche la liste des sondages (Vue image_cffd7f.png)
     */
    public function index()
    {
        $polls = Poll::latest()->get();
        return view('polls.index', compact('polls'));
    }

    /**
     * Affiche le formulaire de création (Vue image_cffdc0.png)
     */
    public function create()
    {
        // Seul l'admin peut accéder à cette page
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Action non autorisée.');
        }
        return view('polls.create');
    }

    /**
     * Enregistre le nouveau sondage
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
            'options' => $request->options, // Casté automatiquement en JSON via le modèle
            'is_active' => true,
        ]);

        return redirect()->route('polls.index')->with('success', 'Sondage publié avec succès !');
    }

    /**
     * Permet à un utilisateur de voter
     */
    public function vote(Request $request, Poll $poll)
    {
        $request->validate([
            'choice' => 'required|string',
        ]);

        // Vérifier si l'utilisateur a déjà voté
        $alreadyVoted = Vote::where('poll_id', $poll->id)
                            ->where('user_id', auth()->id())
                            ->exists();

        if ($alreadyVoted) {
            return back()->with('error', 'Vous avez déjà voté pour ce sondage.');
        }

        Vote::create([
            'poll_id' => $poll->id,
            'user_id' => auth()->id(),
            'choice' => $request->choice,
        ]);

        return back()->with('success', 'Votre vote a été pris en compte.');
    }

    /**
     * Affiche les résultats (Le lien "Voir" dans ton tableau)
     */
    public function results(Poll $poll)
    {
        // Récupérer tous les votes pour ce sondage
        $votes = Vote::where('poll_id', $poll->id)->get();
        $totalVotes = $votes->count();

        // Calculer les statistiques par option
        $stats = [];
        foreach ($poll->options as $option) {
            $count = $votes->where('choice', $option)->count();
            $percentage = $totalVotes > 0 ? ($count / $totalVotes) * 100 : 0;
            
            $stats[] = [
                'option' => $option,
                'count' => $count,
                'percentage' => round($percentage, 1)
            ];
        }

        return view('polls.results', compact('poll', 'stats', 'totalVotes'));
    }

    public function show(Poll $poll)
    {
        if ($poll->hasVoted(auth()->id())) {
            return redirect()->route('polls.results', $poll);
        }
        return view('polls.show', compact('poll'));
    }
}