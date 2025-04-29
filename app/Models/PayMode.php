<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMode extends Model
{
    use HasFactory;

    protected $table = 'mode_payments';

    protected $fillable = [
        'created_by',
        'paymode_name',
        'paymode_account',
        'paymode_status',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
