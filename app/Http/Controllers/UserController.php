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
        // On récupère tous les utilisateurs sauf l'admin connecté pour éviter les erreurs
        // On trie par statut : les "En attente" (is_active = 0) apparaissent en premier
        $users = User::orderBy('is_active', 'asc')->get();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Création d'un utilisateur (via le bouton Ajouter un membre)
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
            'is_active' => true, 
        ]);

        return redirect()->back()->with('success', 'Membre ajouté avec succès !');
    }

    /**
     * Gère l'activation et la suspension (Bouton ACCEPTER)
     */
    public function toggleStatus(User $user)
    {
        // Sécurité : ne pas se désactiver soi-même
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Action impossible sur votre propre compte.');
        }

        // On bascule le statut
        $user->is_active = !$user->is_active;
        $user->save();

        // Message personnalisé selon le nouvel état
        if ($user->is_active) {
            $message = "L'accès de {$user->name} a été validé avec succès.";
            // Note : L'envoi de mail sera ajouté ici plus tard
        } else {
            $message = "L'accès de {$user->name} a été suspendu.";
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Supprime définitivement un utilisateur
     */
    public function destroy(User $user)
    {
        // Sécurité : empêcher l'admin de supprimer son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte administrateur.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "Le compte de $userName a été définitivement supprimé.");
    }

    /**
     * Change le rôle d'un utilisateur
     */
    public function updateRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $user->role = ($user->role === 'admin') ? 'user' : 'admin';
        $user->save();

        return redirect()->back()->with('success', "Le rôle de {$user->name} est maintenant : {$user->role}.");
    }
}