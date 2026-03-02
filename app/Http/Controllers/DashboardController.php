public function index()
{
    $user = auth()->user();
    $today = \Carbon\Carbon::today();

    // --- LOGIQUE ADMIN ---
    if ($user->role === 'admin') {
        $attendanceToday = \App\Models\Attendance::whereDate('date', $today)->count();
        $totalUsers = \App\Models\User::where('role', '!=', 'admin')->count();
        $pendingLeaves = \App\Models\Leave::where('status', 'pending')->count();
        $totalTasks = \App\Models\Task::count();
        $globalPerformance = $totalTasks > 0 ? round(\App\Models\Task::avg('progress')) : 0;
        $recentMissions = \App\Models\Task::with('user')->latest('updated_at')->take(5)->get();
        $users = \App\Models\User::where('role', '!=', 'admin')
            ->with(['attendances' => function($query) use ($today) {
                $query->whereDate('date', $today);
            }])->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'pendingLeaves', 'attendanceToday', 
            'globalPerformance', 'recentMissions', 'users'
        ));
    }

    // --- LOGIQUE UTILISATEUR (Collaborateur) ---
    $myTasks = $user->tasks()->where('is_completed', false)->get();
    $myProgress = round($user->tasks()->avg('progress') ?? 0);
    $myAttendanceToday = $user->attendances()->whereDate('date', $today)->first();

    // CORRECTION ICI : Ton fichier est dans admin/users/
    return view('admin.users.dashboard', compact('myTasks', 'myProgress', 'myAttendanceToday'));
}