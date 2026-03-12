<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Vote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AttendanceReminder; // Importation de la notification

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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Action non autorisée.');
        }
        return view('polls.create');
    }

    /**
     * Enregistre un nouveau sondage et notifie TOUS les employés.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
        ]);

        $poll = Poll::create([
            'title' => $request->title,
            'description' => $request->description,
            'options' => $request->options, 
            'is_active' => true,
        ]);

        // --- AJOUT NOTIFICATION COLLECTIVE ---
        // On récupère tous les utilisateurs (sauf l'admin qui crée le sondage)
        $users = User::where('id', '!=', auth()->id())->get();
        foreach ($users as $user) {
            $user->notify(new AttendanceReminder(
                "📊 Nouveau sondage : " . $poll->title . ". Votre avis nous intéresse !", 
                route('polls.show', $poll->id)
            ));
        }

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

        if ($poll->hasVoted(auth()->id())) {
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
     * Affiche les résultats détaillés d'un sondage.
     */
    public function results(Poll $poll)
    {
        $votes = Vote::where('poll_id', $poll->id)->get();
        $totalVotes = $votes->count();

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
     * Affiche un sondage spécifique.
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