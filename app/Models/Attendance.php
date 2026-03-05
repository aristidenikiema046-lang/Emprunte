<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected $casts = [
        'date' => 'date',
        'check_in_8h30' => 'datetime',
        'check_out_12h00' => 'datetime',
        'check_in_14h00' => 'datetime',
        'check_out_17h00' => 'datetime',
        'is_completed' => 'boolean',
    ];

    // Calcul du retard à l'arrivée
    public function getRetardMinutesAttribute()
    {
        if (!$this->check_in_8h30) return 0;
        
        $heureTheorique = Carbon::parse($this->date)->setTime(8, 30);
        $heureReelle = $this->check_in_8h30;

        if ($heureReelle->gt($heureTheorique->addMinutes(5))) {
            return $heureReelle->diffInMinutes($heureTheorique);
        }
        return 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}