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
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            // Relie la disponibilité à l'utilisateur, supprime si l'utilisateur est supprimé
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Stocke les jours sélectionnés sous forme de JSON (ex: ["Lundi", "Mardi"])
            $table->json('days'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};