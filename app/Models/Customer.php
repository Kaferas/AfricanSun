<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        "customer_firstname","customer_lastname","customer_cni",
        "customer_phone","customer_province","customer_commune",
        "customer_zone","customer_colline","customer_status",
        "created_by","updated_by"
    ];

    public function user(){
        $this->belognsTo(User::class,'created_by');
    }

    public function scopeActive(){
        
    }
}
