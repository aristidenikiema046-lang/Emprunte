<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'user_id', 'problem_solving', 'goals_respect', 'pressure_management', 
        'implication', 'rules_respect', 'schedule_respect', 'presence', 
        'collaboration', 'communication', 'reporting', 'total_score'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    } //
}
