<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
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
        // 1. On tente d'authentifier l'utilisateur (vérification email/password)
        $request->authenticate();

        // 2. Vérification du statut "is_active"
        // Si l'utilisateur est authentifié mais que son compte est à 0 (false)
        if (!auth()->user()->is_active) {
            $userName = auth()->user()->name;
            
            // On le déconnecte immédiatement
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // On le redirige vers le login avec le message d'attente
            return redirect()->route('login')->with('error', "Bonjour $userName, votre accès est en attente de validation par l'administrateur.");
        }

        // 3. Si le compte est actif, on régénère la session normalement
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
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