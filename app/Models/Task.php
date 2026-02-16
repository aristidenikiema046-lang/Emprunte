<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',     // L'ID de celui qui reçoit la tâche
        'title',
        'description',
        'deadline',
        'priority',    // Ex: Basse, Moyenne, Haute
        'status',      // Ex: En attente, En cours, Terminé
        'progress',    // Pour la barre de progression (0 à 100)
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}