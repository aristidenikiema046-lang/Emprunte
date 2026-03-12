<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // <--- AJOUTÉ : Pour gérer la longueur des index
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // FIX : Empêche l'erreur "Syntax error or access violation: 1071 La clé est trop longue"
        Schema::defaultStringLength(191);

        // Définition de la Gate pour les routes Admin
        Gate::define('admin-only', function (User $user) {
            return $user->role === 'admin';
        });
    }
}