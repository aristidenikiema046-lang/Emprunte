<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PollController; 
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EvaluationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // --- Profil ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Présences ---
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/attendances/store', [AttendanceController::class, 'store'])->name('attendances.store');

    // --- Tâches ---
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::patch('/tasks/{task}/progress', [TaskController::class, 'updateProgress'])->name('tasks.progress');
    
    // --- Congés ---
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::patch('/leaves/{leave}/status', [LeaveController::class, 'updateStatus'])->name('leaves.update');

    // --- PAIE (Accès mixte : Admin voit tout, User voit ses bulletins) ---
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index'); 

    // --- ROUTES RÉSERVÉES À L'ADMIN ---
    Route::middleware('can:admin-only')->group(function() {
        Route::post('/payroll', [PayrollController::class, 'store'])->name('payroll.store');
        Route::delete('/payroll/{payroll}', [PayrollController::class, 'destroy'])->name('payroll.destroy');

        // Gestion des Utilisateurs
        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // --- Communication ---
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::patch('/messages/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // --- Sondages ---
    Route::prefix('polls')->name('polls.')->group(function () {
        Route::get('/', [PollController::class, 'index'])->name('index');
        Route::get('/{poll}', [PollController::class, 'show'])->name('show');
        Route::post('/{poll}/vote', [PollController::class, 'vote'])->name('vote');

        // Seul l'admin peut créer
        Route::middleware('can:admin-only')->group(function() {
            Route::get('/create', [PollController::class, 'create'])->name('create');
            Route::post('/', [PollController::class, 'store'])->name('store');
        });
    });

    // --- Documents (Correction de l'erreur RouteNotFound) ---
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/received', [DocumentController::class, 'index'])->name('received'); // Reçus
        Route::get('/sent', [DocumentController::class, 'sent'])->name('sent');         // <--- AJOUTÉ : Résout l'erreur 403/500
        Route::get('/create', [DocumentController::class, 'create'])->name('create');   // <--- AJOUTÉ : Pour le formulaire d'envoi
        Route::post('/', [DocumentController::class, 'store'])->name('store');
        Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
    });

     // --- Évaluations / Notes ---
    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');

    Route::middleware('can:admin-only')->group(function() {
        Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
    });
});

require __DIR__.'/auth.php';