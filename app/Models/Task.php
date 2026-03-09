<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'options', 'is_active'];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function hasVoted($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }
}