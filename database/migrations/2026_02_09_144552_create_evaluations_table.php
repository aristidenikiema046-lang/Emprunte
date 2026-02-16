<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            // On lie la note à un utilisateur (l'employé)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Tes critères de notation (format float pour les points comme 0.75)
            $table->float('problem_solving');      // Max 2
            $table->float('goals_respect');        // Max 0.5
            $table->float('pressure_management');  // Max 1
            $table->float('implication');          // Max 0.5
            $table->float('rules_respect');        // Max 1
            $table->float('schedule_respect');     // Max 0.75
            $table->float('presence');             // Max 0.25
            $table->float('collaboration');        // Max 0.25
            $table->float('communication');        // Max 0.75
            $table->float('reporting');            // Max 2
            
            // Le résultat final calculé
            $table->float('total_score');          // Total sur 9
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};