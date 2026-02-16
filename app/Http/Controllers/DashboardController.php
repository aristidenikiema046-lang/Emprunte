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
        // Sécurité : Seul l'admin accède à cette vue
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('tasks.index'); 
        }

        $today = Carbon::today();

        // 1. Statistiques (Corrigé : on utilise la colonne 'date')
        $attendanceToday = Attendance::whereDate('date', $today)->count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $pendingLeaves = Leave::where('status', 'pending')->count();

        // 2. Performance basée sur le % de progression moyen
        $totalTasks = Task::count();
        $globalPerformance = $totalTasks > 0 ? round(Task::avg('progress')) : 0;

        // 3. Flux d'activité
        $recentMissions = Task::with('user')
            ->latest('updated_at')
            ->take(5)
            ->get();

        // 4. Liste des utilisateurs pour le formulaire ET le Live Status
        // Corrigé : On filtre sur la colonne 'date'
        $users = User::where('role', '!=', 'admin')
            ->with(['attendances' => function($query) use ($today) {
                $query->whereDate('date', $today);
            }])
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'pendingLeaves', 'attendanceToday', 
            'globalPerformance', 'recentMissions', 'users'
        ));
    }
}