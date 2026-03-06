<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $leaves = Leave::with('user')->latest()->get();
            return view('admin.leaves.index', compact('leaves'));
        }

        $leaves = auth()->user()->leaves()->latest()->get();
        return view('leaves.index', compact('leaves'));
    }

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
            'status' => 'en_attente',
        ]);

        return back()->with('success', 'Votre demande de congé a été transmise à l\'administration.');
    }

    public function updateStatus(Request $request, Leave $leave)
    {
        $request->validate(['status' => 'required|in:approuvé,refusé']);
        $leave->update(['status' => $request->status]);

        if ($request->status === 'approuvé') {
            return back()->with('success', "La demande de congé de {$leave->user->name} a été validée.");
        } else {
            return back()->with('error', "La demande de congé de {$leave->user->name} a été refusée.");
        }
    }
}