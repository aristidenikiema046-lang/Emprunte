<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();

        // --- LOGIQUE ADMIN ---
        if ($user->role === 'admin') {
            $attendanceToday = Attendance::whereDate('date', $today)->count();
            $totalUsers = User::where('role', '!=', 'admin')->count();
            $pendingLeaves = Leave::where('status', 'pending')->count();
            $totalTasks = Task::count();
            $globalPerformance = $totalTasks > 0 ? round(Task::avg('progress')) : 0;
            $recentMissions = Task::with('user')->latest('updated_at')->take(5)->get();
            $users = User::where('role', '!=', 'admin')
                ->with(['attendances' => function($query) use ($today) {
                    $query->whereDate('date', $today);
                }])->get();

            return view('admin.dashboard', compact(
                'totalUsers', 'pendingLeaves', 'attendanceToday', 
                'globalPerformance', 'recentMissions', 'users'
            ));
        }

        // --- LOGIQUE UTILISATEUR (Collaborateur) ---
        // On récupère les variables individuelles pour correspondre au fichier Blade
        $myTasks = $user->tasks()->where('is_completed', false)->get();
        $myProgress = round($user->tasks()->avg('progress') ?? 0);
        $myAttendanceToday = $user->attendances()->whereDate('date', $today)->first();
        $myPendingLeavesCount = $user->leaves()->where('status', 'pending')->count();

        // On pointe vers le dossier "user" (vérifiez si votre dossier est 'user' ou 'users')
        return view('users.dashboard', compact('myTasks', 'myProgress', 'myAttendanceToday', 'myPendingLeavesCount'));
    }
}