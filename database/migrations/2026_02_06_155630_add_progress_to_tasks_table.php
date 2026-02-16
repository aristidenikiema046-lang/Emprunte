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
        // AJOUTE LE CODE ICI :
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('progress')->default(0)->after('title'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Ajoute cette condition pour éviter l'erreur si la colonne n'existe pas
            if (Schema::hasColumn('tasks', 'progress')) {
                $table->dropColumn('progress');
            }
        });
    }
};