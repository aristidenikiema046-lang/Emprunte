<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'progress',
        'is_completed',
        'completed_at',
        'due_date' // <--- Ajouté ici
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}