<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\User;
use App\Notifications\AttendanceReminder;
use Barryvdh\DomPDF\Facade\Pdf as PDF; // L'alias important ici
use Illuminate\Support\Facades\Storage;

class PayrollController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $payrolls = Payroll::with('user')->latest()->get();
            $users = User::all();
        } else {
            $payrolls = Payroll::where('user_id', $user->id)->latest()->get();
            $users = collect();
        }
        return view('payroll.index', compact('payrolls', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'month' => 'required|string',
            'amount' => 'required|numeric',
            'status' => 'required',
        ]);

        $user = User::find($request->user_id);

        // 1. Préparation des données pour le PDF
        $data = [
            'user' => $user,
            'month' => $request->month,
            'amount' => $request->amount,
            'date' => now()->format('d/m/Y'),
        ];

        // 2. Génération du PDF avec la vue payroll.pdf
        // Assure-toi d'avoir créé resources/views/payroll/pdf.blade.php
        $pdf = PDF::loadView('payroll.pdf', $data);
        
        // 3. Définition du chemin de stockage
        $fileName = 'bulletin_' . $user->id . '_' . time() . '.pdf';
        $path = 'bulletins/' . $fileName;

        // 4. Sauvegarde physique du fichier
        Storage::disk('public')->put($path, $pdf->output());

        // 5. Enregistrement en Base de Données
        Payroll::create([
            'user_id' => $request->user_id,
            'month' => $request->month,
            'amount' => $request->amount,
            'status' => $request->status,
            'pdf_path' => $path,
        ]);

        // 6. Notification à l'employé
        $user->notify(new AttendanceReminder(
            "💵 Un nouveau bulletin de paie est disponible pour le mois de : " . $request->month, 
            route('payroll.index')
        ));

        return back()->with('success', 'Le bulletin a été généré avec succès !');
    }

    public function destroy(Payroll $payroll)
    {
        if ($payroll->pdf_path) {
            Storage::disk('public')->delete($payroll->pdf_path);
        }
        $payroll->delete();
        return back()->with('success', 'Bulletin supprimé.');
    }
}