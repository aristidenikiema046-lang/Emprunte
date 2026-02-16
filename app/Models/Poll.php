<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'title',
        'description',
        'options',
        'is_active'
    ];

    /**
     * Le cast indispensable pour transformer le JSON en tableau PHP automatiquement.
     * C'est ce qui permet au Controller de faire $poll->options sans erreur.
     */
    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relation : Un sondage possède plusieurs votes.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Vérifie si l'utilisateur connecté a déjà voté pour ce sondage.
     * Très utile pour l'affichage des boutons dans ta vue index.
     */
    public function hasVoted($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }
}