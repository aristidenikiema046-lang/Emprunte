<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function index()
    {
        // On récupère tous les utilisateurs
        // On peut trier pour mettre les "En attente" (is_active = 0) en haut
        $users = User::orderBy('is_active', 'asc')->get();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Création d'un utilisateur via le bouton "Ajouter un membre" (Modal)
     */
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
            'role' => 'user',
            'is_active' => true, // Les comptes créés par l'admin sont actifs par défaut
        ]);

        return redirect()->back()->with('success', 'Collaborateur ajouté avec succès !');
    }

    /**
     * Alterne le rôle entre 'admin' et 'user'
     */
    public function updateRole(User $user)
    {
        // Sécurité : ne pas modifier son propre rôle pour ne pas perdre l'accès admin
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $newRole = ($user->role === 'admin') ? 'user' : 'admin';
        $user->update(['role' => $newRole]);

        return redirect()->back()->with('success', "Le rôle de {$user->name} a été mis à jour.");
    }

    /**
     * Alterne le statut entre Actif (1) et Bloqué (0)
     * C'est cette fonction qui est appelée par le bouton "ACCEPTER"
     */
    public function toggleStatus(User $user)
    {
        // Sécurité : ne pas se bloquer soi-même
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Action impossible sur votre propre compte.');
        }

        // On inverse la valeur actuelle (0 devient 1, 1 devient 0)
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $statusMessage = $user->is_active 
            ? "L'accès de {$user->name} a été validé avec succès." 
            : "L'accès de {$user->name} a été suspendu.";

        return redirect()->back()->with('success', $statusMessage);
    }

    /**
     * Supprime définitivement un utilisateur
     */
    public function destroy(User $user)
    {
        // Sécurité : ne pas se supprimer soi-même
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->back()->with('success', "Le compte a été supprimé définitivement.");
    }
}