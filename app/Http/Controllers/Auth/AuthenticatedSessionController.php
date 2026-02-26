<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Authentification (Vérifie email et password)
        $request->authenticate();

        // 2. Vérification du statut is_active
        if (!auth()->user()->is_active) {
            $name = auth()->user()->name;
            
            // Déconnexion immédiate si le compte n'est pas validé
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', "Désolé $name, votre accès n'a pas encore été validé par l'administrateur.");
        }

        // 3. Si tout est bon, on génère la session
        $request->session()->regenerate();

        // 4. Redirection vers le dashboard (Correction de l'erreur RouteServiceProvider)
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}