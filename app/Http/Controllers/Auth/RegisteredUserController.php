<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'invite_code' => ['required', 'string', function ($attribute, $value, $fail) {
                if ($value !== config('app.invitation_code', env('INVITATION_CODE'))) {
                    $fail('Le code d\'invitation est incorrect. Accès réservé au personnel.');
                }
            }],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'is_active' => false, // BLOQUÉ PAR DÉFAUT
        ]);

        event(new Registered($user));

        // Suppression de Auth::login($user); pour ne pas connecter l'utilisateur
        
        return redirect()->route('login')->with('success', 'Demande envoyée ! L\'administrateur doit valider votre accès.');
    }
}