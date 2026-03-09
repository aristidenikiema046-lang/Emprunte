<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Http\Controllers\EvaluationController;
use Illuminate\Http\Request;

class GenerateWeeklyEvaluations extends Command
{
    // C'est le nom de la commande que le serveur appellera
    protected $signature = 'evaluations:generate-weekly';
    protected $description = 'Calcul automatique des performances (Vendredi 18h)';

    public function handle()
    {
        $this->info('Début de l\'audit hebdomadaire...');

        // On récupère tous les employés (pas les admins)
        $users = User::where('role', '!=', 'admin')->get();
        $controller = new EvaluationController();

        foreach ($users as $user) {
            // On crée une fausse requête pour réutiliser la logique du Controller
            $request = new Request(['user_id' => $user->id]);
            $controller->store($request);
            
            $this->line("Évaluation générée pour : {$user->name}");
        }

        $this->info('Audit terminé avec succès à 18:00.');
    }
}