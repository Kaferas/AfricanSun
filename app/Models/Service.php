<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    
    protected $fillable = [
        'service_name',
        'service_description',
        'service_price',
        'service_duration',
        'service_status',
        'created_by',
        'updated_by'
    ];

    public function scopeActive($query)
    {
        $query->where('service_status', 0);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    } 
}
