<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\User;

class PayrollController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // On vérifie le rôle pour filtrer les données
        if ($user->role === 'admin') {
            $payrolls = Payroll::with('user')->latest()->get();
            $users = User::all(); // Pour le select du formulaire
        } else {
            $payrolls = Payroll::where('user_id', $user->id)->latest()->get();
            $users = collect(); // On envoie une collection vide (sécurité)
        }

        return view('payroll.index', compact('payrolls', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'month' => 'required',
            'amount' => 'required|numeric',
            'status' => 'required',
            'pdf' => 'nullable|mimes:pdf|max:2048'
        ]);

        $path = $request->file('pdf') ? $request->file('pdf')->store('bulletins', 'public') : null;

        Payroll::create([
            'user_id' => $request->user_id,
            'month' => $request->month,
            'amount' => $request->amount,
            'status' => $request->status,
            'pdf_path' => $path
        ]);

        return back()->with('success', 'Bulletin enregistré avec succès.');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return back()->with('success', 'Bulletin supprimé.');
    }
}