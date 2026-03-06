<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('is_active', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

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

        return redirect()->back()->with('success', "Le nouveau collaborateur {$request->name} a été ajouté avec succès !");
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Alerte : Vous ne pouvez pas suspendre votre propre compte administrateur.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        if ($user->is_active) {
            return redirect()->back()->with('success', "Accès autorisé : {$user->name} peut maintenant se connecter.");
        } else {
            return redirect()->back()->with('error', "Accès révoqué : Le compte de {$user->name} est désormais suspendu.");
        }
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Action interdite : Suppression de votre propre compte impossible.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "Le profil de $userName a été définitivement retiré du système.");
    }

    public function updateRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Modification impossible : Vous ne pouvez pas changer votre propre rôle.');
        }

        $user->role = ($user->role === 'admin') ? 'user' : 'admin';
        $user->save();

        $statusType = $user->role === 'admin' ? 'success' : 'error';
        $msg = "Mise à jour : {$user->name} est désormais enregistré comme {$user->role}.";

        return redirect()->back()->with($statusType, $msg);
    }
}