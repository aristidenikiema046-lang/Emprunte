<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'date', 
        'check_in_8h30', 
        'check_out_12h00', 
        'check_in_14h00', 
        'check_out_17h00', 
        'is_completed'
    ];

    /**
     * Le cast permet de transformer automatiquement les colonnes en objets Carbon.
     * C'est indispensable pour gérer les colonnes de type 'timestamp'.
     */
    protected $casts = [
        'date' => 'date',
        'check_in_8h30' => 'datetime',
        'check_out_12h00' => 'datetime',
        'check_in_14h00' => 'datetime',
        'check_out_17h00' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}