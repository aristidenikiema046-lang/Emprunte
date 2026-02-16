<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Affiche la liste des tâches (Admin voit tout, Employé voit les siennes).
     */
    public function index()
    {
        $users = User::all();

        // On utilise eager loading (with('user')) pour éviter les requêtes SQL inutiles
        if (auth()->user()->isAdmin()) {
            $tasks = Task::with('user')->latest()->get();
        } else {
            $tasks = auth()->user()->tasks()->latest()->get();
        }

        return view('tasks.index', compact('tasks', 'users'));
    }

    /**
     * Enregistre une nouvelle tâche (Admin uniquement).
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'priority' => 'nullable|in:basse,moyenne,haute',
        ]);

        Task::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'priority' => $request->priority ?? 'moyenne',
            'progress' => 0, // Initialisation à 0%
            'is_completed' => false,
        ]);

        return back()->with('success', 'Mission assignée avec succès !');
    }

    /**
     * Mise à jour de la progression via le curseur (Slider).
     * C'est ce qui permet le suivi "en temps réel" sur le dashboard.
     */
    public function updateProgress(Request $request, Task $task)
    {
        // Sécurité : Seul l'employé assigné peut modifier son avancement
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez pas modifier une tâche qui ne vous est pas assignée.');
        }

        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $task->update([
            'progress' => $request->progress,
            // Si le progrès atteint 100, on marque automatiquement comme terminé
            'is_completed' => ($request->progress == 100),
            'completed_at' => ($request->progress == 100) ? now() : null,
        ]);

        return back()->with('success', "Progression mise à jour : {$request->progress}%");
    }

    /**
     * Basculer rapidement entre terminé et en cours.
     */
    public function toggle(Task $task)
    {
        if ($task->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $newStatus = !$task->is_completed;

        $task->update([
            'is_completed' => $newStatus,
            'progress' => $newStatus ? 100 : 0, // On synchronise le progrès avec le bouton
            'completed_at' => $newStatus ? now() : null
        ]);

        return back()->with('success', 'Statut mis à jour.');
    }
}