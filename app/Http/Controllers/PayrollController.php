<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\User;
use App\Notifications\AttendanceReminder;
use Barryvdh\DomPDF\Facade\Pdf; // Import du moteur PDF
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
            'month' => 'required',
            'amount' => 'required|numeric',
            'status' => 'required',
        ]);

        $user = User::find($request->user_id);

        // --- GÉNÉRATION AUTOMATIQUE DU PDF ---
        $data = [
            'user' => $user,
            'month' => $request->month,
            'amount' => $request->amount,
            'date' => now()->format('d/m/Y')
        ];

        $pdf = Pdf::loadView('payroll.pdf', $data);
        
        // Nom du fichier unique
        $fileName = 'bulletin_' . $user->id . '_' . str_replace('/', '-', $request->month) . '.pdf';
        $path = 'bulletins/' . $fileName;

        // Sauvegarde sur le serveur (storage/app/public/bulletins)
        Storage::disk('public')->put($path, $pdf->output());

        // --- CRÉATION EN BDD ---
        $payroll = Payroll::create([
            'user_id' => $request->user_id,
            'month' => $request->month,
            'amount' => $request->amount,
            'status' => $request->status,
            'pdf_path' => $path // On enregistre le chemin du PDF généré
        ]);

        // Notification
        $user->notify(new AttendanceReminder(
            "💵 Votre fiche de paie de " . $request->month . " a été générée automatiquement.", 
            route('payroll.index')
        ));

        return back()->with('success', 'Bulletin généré et envoyé avec succès.');
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