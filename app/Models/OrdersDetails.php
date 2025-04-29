<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdersDetails extends Model
{
    protected $fillable = [
        "order_id","service_id","ref_order_code","service_name",
        "service_price","sold_price","htva_price","tva_price",
        "tc_price","pf_price","detail_status","created_by",
        "updated_by","sold_qty"
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(Orders::class,'order_id');
    }

}
