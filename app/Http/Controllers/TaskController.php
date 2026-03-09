<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();

        if (auth()->user()->role === 'admin') {
            $tasks = Task::with('user')->latest()->get();
        } else {
            $tasks = auth()->user()->tasks()->latest()->get();
        }

        return view('tasks.index', compact('tasks', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
        ]);

        Task::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'progress' => 0,
            'is_completed' => false,
        ]);

        return back()->with('success', "Mission assignée avec succès !");
    }

    public function updateProgress(Request $request, Task $task)
    {
        if ($task->user_id != auth()->id()) {
            abort(403, "Seul le collaborateur assigné peut modifier sa progression.");
        }

        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $task->update([
            'progress' => $request->progress,
            'is_completed' => ($request->progress == 100),
            'completed_at' => ($request->progress == 100) ? now() : null,
        ]);

        return back()->with('success', "Progression mise à jour : {$request->progress}%");
    }

    public function toggle(Task $task)
    {
        if ($task->user_id != auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $newStatus = !$task->is_completed;
        $task->update([
            'is_completed' => $newStatus,
            'progress' => $newStatus ? 100 : 0,
            'completed_at' => $newStatus ? now() : null
        ]);

        return back()->with('success', $newStatus ? "Mission clôturée." : "Mission réactivée.");
    }

    public function destroy(Task $task)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $task->delete();
        return back()->with('error', 'Mission supprimée.');
    }
}