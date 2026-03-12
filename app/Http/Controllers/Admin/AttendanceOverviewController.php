<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceOverviewController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // On récupère tous les utilisateurs avec leur pointage du jour
        $users = User::with(['attendances' => function($query) use ($today) {
            $query->whereDate('date', $today);
        }])->where('role', '!=', 'admin')->get();

        return view('admin.attendances.index', compact('users'));
    }
}