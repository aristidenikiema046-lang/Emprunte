<?php

namespace App\Http\Controllers;

use App\Models\{User, Attendance, Leave, Task, Evaluation, Message, Poll};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        // ==========================================
        // LOGIQUE ADMIN : Vue d'ensemble Entreprise
        // ==========================================
        if ($user->isAdmin()) {
            $totalUsers = User::where('role', '!=', 'admin')->count();
            $attendanceToday = Attendance::whereDate('date', $today)->count();
            $pendingLeaves = Leave::where('status', 'pending')->count();
            
            // Calcul performance globale (Moyenne des évaluations sur 9)
            $globalPerformance = Evaluation::avg('total_score') ?? 0;
            
            // Flux d'activités pour l'admin
            $recentMissions = Task::with('user')->latest()->take(5)->get();
            
            // Liste des employés avec leur statut de présence du jour
            $users = User::where('role', '!=', 'admin')
                ->with(['attendances' => function($q) use ($today) {
                    $q->whereDate('date', $today);
                }])->get();

            return view('admin.dashboard', compact(
                'totalUsers', 'attendanceToday', 'pendingLeaves', 
                'globalPerformance', 'recentMissions', 'users'
            ));
        }

        // ==========================================
        // LOGIQUE COLLABORATEUR : Performance Perso
        // ==========================================
        
        // 1. Tâches & Progression
        $myTasks = Task::where('user_id', $user->id)->where('is_completed', false)->get();
        $totalMyTasks = Task::where('user_id', $user->id)->count();
        $completedMyTasks = Task::where('user_id', $user->id)->where('is_completed', true)->count();
        $myProgress = $totalMyTasks > 0 ? ($completedMyTasks / $totalMyTasks) * 100 : 0;

        // 2. Présence du jour
        $myAttendanceToday = Attendance::where('user_id', $user->id)->whereDate('date', $today)->first();

        // 3. Système de Notifications (Temps réel)
        $notifications = collect();
        
        // Messages non lus
        $unreadMessages = Message::where('receiver_id', $user->id)->where('is_read', false)->count();
        if($unreadMessages > 0) $notifications->push(['type' => 'blue', 'text' => "Vous avez $unreadMessages nouveau(x) message(s)."]);

        // Sondages à voter
        $pendingPolls = Poll::where('is_active', true)->get()->filter(fn($p) => !$p->hasVoted($user->id))->count();
        if($pendingPolls > 0) $notifications->push(['type' => 'amber', 'text' => "Sondage en attente : Donnez votre avis !"]);

        // 4. Performance (Dernière note)
        $lastEval = Evaluation::where('user_id', $user->id)->latest()->first();

        return view('admin.users.dashboard', compact(
            'myTasks', 'myProgress', 'myAttendanceToday', 
            'notifications', 'lastEval', 'completedMyTasks', 'totalMyTasks'
        ));
    }
}