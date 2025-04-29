<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'agents';

    // Define which fields can be mass-assigned (whitelist)
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'province',
        'commune',
        'colline',
        'zone',
    ];

    // Define any fields that should be cast to a specific type
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
