<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // On autorise Laravel à remplir ces colonnes
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'file_path',
        'file_name',
        'is_read',
    ];

    /**
     * Relation avec l'expéditeur
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relation avec le destinataire
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}