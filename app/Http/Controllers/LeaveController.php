<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\AttendanceReminder;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
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
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2Mo
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $leave = Leave::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
            'status' => 'en_attente',
        ]);

        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new AttendanceReminder(
                "✈️ Nouvelle demande de congé de " . auth()->user()->name, 
                route('leaves.index')
            ));
        }

        return back()->with('success', 'Votre demande de congé avec justificatif a été transmise.');
    }

    public function updateStatus(Request $request, Leave $leave)
    {
        $request->validate(['status' => 'required|in:approuvé,refusé']);
        $leave->update(['status' => $request->status]);

        $icon = $request->status === 'approuvé' ? '✅' : '❌';
        $leave->user->notify(new AttendanceReminder(
            "$icon Votre demande de congé ({$leave->type}) a été {$request->status}.", 
            route('leaves.index')
        ));

        return back()->with('success', "Le statut a été mis à jour avec succès.");
    }
}