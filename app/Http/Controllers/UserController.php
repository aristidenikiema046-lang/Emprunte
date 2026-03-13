<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Obligatoire ici
        ]);

        $path = null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $path,
            'role' => 'user',
            'is_active' => true, 
        ]);

        return redirect()->back()->with('success', "Le nouveau collaborateur {$request->name} a été ajouté avec succès !");
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Alerte : Vous ne pouvez pas suspendre votre propre compte.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->back()->with('success', "Le statut de {$user->name} a été modifié.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Action interdite.');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
        return redirect()->back()->with('success', "Profil retiré du système.");
    }

    public function updateRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Impossible de changer votre propre rôle.');
        }

        $user->role = ($user->role === 'admin') ? 'user' : 'admin';
        $user->save();

        return redirect()->back()->with('success', "Rôle mis à jour.");
    }
}