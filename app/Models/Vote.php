<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     * C'est ici qu'on autorise l'enregistrement du vote.
     */
    protected $fillable = [
        'poll_id',
        'user_id',
        'choice',
    ];

    /**
     * Relation : Un vote appartient à un sondage.
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Relation : Un vote appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}