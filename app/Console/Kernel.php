<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Attendance;
use App\Notifications\AttendanceReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Ici, on définit les tâches que le serveur doit faire tout seul.
     */
    protected function schedule(Schedule $schedule): void
    {
        // 1. Pause Déjeuner Automatique à 12h00
        $schedule->call(function () {
            $this->autoPointWithNotification(
                'check_out_12h00', 
                12, 0, 
                "🍽️ C'est l'heure de la pause ! Pointage automatique effectué à 12:00.", 
                false
            );
        })->dailyAt('12:00')->timezone('Africa/Abidjan');

        // 2. Reprise de Service Automatique à 14h00
        $schedule->call(function () {
            $this->autoPointWithNotification(
                'check_in_14h00', 
                14, 0, 
                "💻 Fin de la pause. Reprise automatique effectuée à 14:00. Bon travail !", 
                false
            );
        })->dailyAt('14:00')->timezone('Africa/Abidjan');

        // 3. Fermer la journée à 17h15 (Sécurité pour la Descente)
        $schedule->call(function () {
            $this->autoPointWithNotification(
                'check_out_17h00', 
                17, 0, 
                "✅ Journée terminée ! Votre descente a été validée automatiquement.", 
                true
            );
        })->dailyAt('17:15')->timezone('Africa/Abidjan');

        // 4. Génération des évaluations hebdomadaires le Vendredi
        $schedule->command('evaluations:generate-weekly')
                ->weeklyOn(5, '18:00')
                ->timezone('Africa/Abidjan');
    }

    /**
     * Logique qui remplit les points manquants et envoie une notification
     */
    private function autoPointWithNotification($column, $hour, $minute, $message, $isCompleted = false)
    {
        $today = Carbon::today();
        $timeValue = Carbon::today()->setTime($hour, $minute);

        // On récupère les présences qui ont débuté la journée (8h30) mais n'ont pas encore validé cette étape
        $attendances = Attendance::whereDate('date', $today)
            ->whereNotNull('check_in_8h30')
            ->whereNull($column)
            ->get();

        foreach ($attendances as $attendance) {
            // Mise à jour de la base de données
            $attendance->update([
                $column => $timeValue,
                'is_completed' => $isCompleted ? true : $attendance->is_completed
            ]);

            // Envoi de la notification à l'employé
            if ($attendance->user) {
                $attendance->user->notify(new AttendanceReminder($message, route('attendances.index')));
            }
        }
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