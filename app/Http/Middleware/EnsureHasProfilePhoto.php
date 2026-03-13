<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasProfilePhoto
{
    public function handle(Request $request, Closure $next): Response
    {
        // On laisse passer si : l'utilisateur n'est pas connecté OU a déjà une photo
        // OU s'il essaie d'accéder à la page profil ou de se déconnecter
        if (auth()->check() && !auth()->user()->avatar) {
            if (!$request->routeIs('profile.*') && !$request->is('logout')) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Vous devez uploader une photo de profil pour continuer.');
            }
        }

        return $next($request);
    }
}