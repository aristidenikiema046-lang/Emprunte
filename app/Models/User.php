<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',                    // Photo de profil
        'employee_id',              // ID Employé (ex: EMP20260002)
        'phone',
        'department',
        'post',
        'gender',
        'birth_date',
        'contract_type',
        'hire_date',
        'address',                  // Adresse
        'family_status',            // Situation familiale (ex: Célibataire)
        'cnps_number',              // Numéro CNPS
        'emergency_contact_name',   // Nom contact urgence
        'emergency_contact_phone',  // Tel contact urgence
        'emergency_contact_relation', // Lien de parenté (ex: Épouse, Frère)
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'hire_date' => 'date',
        ];
    }

    /**
     * Relation avec les tâches
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Relation avec les congés
     */
    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    /**
     * Relation avec les présences (Correction de l'erreur actuelle)
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}