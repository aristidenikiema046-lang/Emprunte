<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    // Affiche la page des congés (Vérifie si Admin ou Employé)
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $leaves = Leave::with('user')->latest()->get();
            return view('admin.leaves.index', compact('leaves'));
        }

        $leaves = auth()->user()->leaves()->latest()->get();
        return view('leaves.index', compact('leaves'));
    }

    // Enregistrement d'une demande par l'employé
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        Leave::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Demande de congé envoyée !');
    }

    // Validation par l'Admin
    public function updateStatus(Request $request, Leave $leave)
    {
        $request->validate(['status' => 'required|in:approuvé,refusé']);
        $leave->update(['status' => $request->status]);

        return back()->with('success', 'Statut du congé mis à jour.');
    }
}