<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'month',
        'amount',
        'status',
        'pdf_path' // Assure-toi que c'est bien pdf_path et non file_path
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}