<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    // Autoriser l'écriture de ces colonnes
    protected $fillable = [
        'title', 
        'file_path', 
        'sender_id', 
        'receiver_id'
    ];

    /**
     * Relation : L'utilisateur qui a envoyé le document.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relation : L'utilisateur qui reçoit le document.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}