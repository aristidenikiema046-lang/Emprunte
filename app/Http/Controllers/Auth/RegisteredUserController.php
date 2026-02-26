<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère une demande d'inscription entrante.
     */
    public function store(Request $request): RedirectResponse
    {
        // On retire la validation de 'invite_code' car le champ est supprimé de la vue
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'is_active' => false, // L'utilisateur est bloqué jusqu'à validation par l'admin
        ]);

        event(new Registered($user));

        // L'utilisateur n'est PAS connecté automatiquement (Auth::login est retiré)
        
        return redirect()->route('login')->with('success', 'Votre demande d\'accès a été envoyée ! Un administrateur doit maintenant valider votre compte.');
    }
}