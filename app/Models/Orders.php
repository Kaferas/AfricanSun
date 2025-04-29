<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    protected $fillable = [
        "order_code","invoice_number","customer_id",
        "order_status","order_delete_status","created_by",
        "updated_by","deleted_by","order_delete_comment",
        "deleted_at"
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function orderDetails() : HasMany
    {
        return $this->hasMany(OrdersDetails::class);
    }
}
