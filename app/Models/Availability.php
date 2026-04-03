<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = ['user_id', 'days'];

    protected $casts = [
        'days' => 'array', // Très important pour manipuler les jours comme un tableau PHP
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}