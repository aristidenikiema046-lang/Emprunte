<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        // Compte total pour l'affichage "Total : X collaborateurs"
        $totalCollaborateurs = User::count(); 
        return view('admin.users.index', compact('users', 'totalCollaborateurs'));
    }

    // Fonction pour le bouton "CRÉER" du formulaire modal
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Par défaut, on crée un employé
        ]);

        return redirect()->back()->with('success', 'Utilisateur créé avec succès !');
    }

    // Fonction pour changer le rôle (Admin <-> Employé)
    public function updateRole(Request $request, User $user)
    {
        // On bascule le rôle
        $newRole = ($user->role === 'admin') ? 'user' : 'admin';
        
        // Sécurité : ne pas s'enlever son propre rôle admin
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $user->update(['role' => $newRole]);

        return redirect()->back()->with('success', 'Rôle mis à jour pour ' . $user->name);
    }
}