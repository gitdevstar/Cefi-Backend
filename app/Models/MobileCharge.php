<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency',
        'network',
        'amount',
        'email',
        'phone',
        'full_name',
        'status',
        'txn_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
