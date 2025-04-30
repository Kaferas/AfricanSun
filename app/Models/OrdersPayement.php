<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdersPayement extends Model
{
    protected $fillable = [
        "invoice_number","mode","price","paid_by"
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'paid_by');
    }
}
