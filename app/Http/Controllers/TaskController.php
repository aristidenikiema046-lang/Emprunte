<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Notifications\AttendanceReminder;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();

        // Système de tri : 
        // 1. Les tâches non complétées d'abord (is_completed asc)
        // 2. Les plus urgentes d'abord (due_date asc)
        $query = Task::with('user')
            ->orderBy('is_completed', 'asc') 
            ->orderBy('due_date', 'asc');

        if (auth()->user()->role === 'admin') {
            $tasks = $query->get();
        } else {
            $tasks = $query->where('user_id', auth()->id())->get();
        }

        return view('tasks.index', compact('tasks', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $task = Task::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'due_date' => $request->due_date,
            'progress' => 0,
            'is_completed' => false,
        ]);

        $assignedUser = User::find($request->user_id);
        $deadline = Carbon::parse($task->due_date)->format('d/m H:i');
        
        $assignedUser->notify(new AttendanceReminder(
            "📌 Nouvelle mission : {$task->title} (Échéance : {$deadline})", 
            route('tasks.index')
        ));

        return back()->with('success', "Mission assignée (Échéance : {$deadline})");
    }

    public function updateProgress(Request $request, Task $task)
    {
        if ($task->user_id != auth()->id()) {
            abort(403);
        }

        $request->validate(['progress' => 'required|integer|min:0|max:100']);

        $isNowCompleted = ($request->progress == 100 && !$task->is_completed);

        $task->update([
            'progress' => $request->progress,
            'is_completed' => ($request->progress == 100),
            'completed_at' => ($request->progress == 100) ? now() : null,
        ]);

        if ($isNowCompleted) {
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->notify(new AttendanceReminder(
                    "✅ Mission terminée par " . auth()->user()->name . " : " . $task->title, 
                    route('tasks.index')
                ));
            }
        }

        return back()->with('success', "Progression : {$request->progress}%");
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
        if (auth()->user()->role !== 'admin') abort(403);
        $task->delete();
        return back()->with('error', 'Mission supprimée.');
    }
}