<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     * On y ajoute 'user_id' pour régler ton erreur MassAssignmentException.
     */
    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    /**
     * Relation : Un congé appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}