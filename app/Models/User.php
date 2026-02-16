<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Vérification simplifiée du rôle
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function tasks() { return $this->hasMany(Task::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function leaves() { return $this->hasMany(Leave::class); }
}