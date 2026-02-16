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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
        
            // 1. Le titre du document (ex: "Contrat de travail")
            $table->string('title');

            // 2. Le chemin vers le fichier stocké dans /storage/app/public/documents
            $table->string('file_path');

            // 3. L'ID de celui qui ENVOIE (lié à la table users)
            $table->foreignId('sender_id')
                ->constrained('users')
                ->onDelete('cascade'); // Si l'user est supprimé, ses envois aussi

            // 4. L'ID de celui qui REÇOIT (lié à la table users)
            $table->foreignId('receiver_id')
                ->constrained('users')
                ->onDelete('cascade'); // Si le destinataire est supprimé, le doc aussi

            // 5. Dates de création (Envoyé le...) et mise à jour
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
