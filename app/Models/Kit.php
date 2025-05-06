<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kit extends Model
{
    protected $fillable = [
        "customer_id","kit_title","kit_serial_number",
        "kit_status","created_by","updated_by"
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function token(): HasMany
    {
        return $this->hasMany(Token::class);
    }
}
