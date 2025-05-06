<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Token extends Model
{
    protected $fillable = [
        "kit_id","generated_token","token_type","end_token_date","created_by"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function kit(): BelongsTo
    {
        return $this->belongsTo(Kit::class,'kit_id');
    }
}
