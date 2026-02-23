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

        if (auth()->user()->isAdmin()) {
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

        return back()->with('success', 'Mission assignée !');
    }

    public function updateProgress(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['progress' => 'required|integer|min:0|max:100']);

        $task->update([
            'progress' => $request->progress,
            'is_completed' => ($request->progress == 100),
            'completed_at' => ($request->progress == 100) ? now() : null,
        ]);

        return back();
    }

    public function toggle(Task $task)
    {
        if ($task->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $newStatus = !$task->is_completed;

        $task->update([
            'is_completed' => $newStatus,
            'progress' => $newStatus ? 100 : 90, // Si on rouvre, on met à 90%
            'completed_at' => $newStatus ? now() : null
        ]);

        return back();
    }
}