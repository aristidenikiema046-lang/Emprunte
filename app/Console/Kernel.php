<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Ici, on définit les tâches que le serveur doit faire tout seul.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Tâche 1 : Fermer la pause déjeuner à 12h15
        $schedule->call(function () {
            $this->autoPoint('check_out_12h00', 12, 0);
        })->dailyAt('12:15');

        // Tâche 2 : Fermer la journée à 17h15 (Auto-Descente)
        $schedule->call(function () {
            $this->autoPoint('check_out_17h00', 17, 0, true);
        })->dailyAt('17:15');

        {
        // On appelle notre commande tous les vendredis à 18h00
        $schedule->command('evaluations:generate-weekly')
                ->weeklyOn(5, '18:00')
                ->timezone('Africa/Abidjan'); 
        }
    }

    /**
     * La logique qui cherche les oublis et les remplit
     */
    private function autoPoint($column, $hour, $minute, $isCompleted = false)
    {
        $today = Carbon::today();
        $timeValue = Carbon::today()->setTime($hour, $minute);

        // On cherche ceux qui ont pointé l'arrivée mais pas cette étape
        Attendance::whereDate('date', $today)
            ->whereNotNull('check_in_8h30')
            ->whereNull($column)
            ->update([
                $column => $timeValue,
                'is_completed' => $isCompleted ? true : DB::raw('is_completed')
            ]);
    }

    /**
     * Enregistrer les commandes (standard Laravel)
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}