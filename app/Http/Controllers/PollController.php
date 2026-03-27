<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Vote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AttendanceReminder;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::latest()->get();
        return view('polls.index', compact('polls'));
    }

    /**
     * Affiche le formulaire de création.
     * Le middleware 'can:admin-only' dans web.php gère déjà la sécurité.
     */
    public function create()
    {
        return view('polls.create');
    }

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

        $users = User::where('id', '!=', auth()->id())->get();
        foreach ($users as $user) {
            $user->notify(new AttendanceReminder(
                "📊 Nouveau sondage : " . $poll->title . ". Votre avis nous intéresse !", 
                route('polls.show', $poll->id)
            ));
        }

        return redirect()->route('polls.index')->with('success', 'Sondage publié avec succès !');
    }

    public function show(Poll $poll)
    {
        if ($poll->hasVoted(auth()->id())) {
            return redirect()->route('polls.results', $poll);
        }
        return view('polls.show', compact('poll'));
    }

    public function vote(Request $request, Poll $poll)
    {
        $request->validate(['choice' => 'required|string']);

        if ($poll->hasVoted(auth()->id())) {
            return back()->with('error', 'Vous avez déjà voté pour ce sondage.');
        }

        Vote::create([
            'poll_id' => $poll->id,
            'user_id' => auth()->id(),
            'choice' => $request->choice,
        ]);

        return redirect()->route('polls.results', $poll)->with('success', 'Votre vote a été pris en compte.');
    }

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
}