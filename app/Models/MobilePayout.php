<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobilePayout extends Model
{
    use HasFactory;

    protected $attributes = [
        'user_id',
        'currency',
        'type',
        'amount',
        'email',
        'phone',
        'full_name',
        'fee',
        'status',
        'txn_id',
        'tx_ref',
    ];

    protected $fillable = [
        'user_id',
        'currency',
        'type',
        'amount',
        'email',
        'phone',
        'full_name',
        'fee',
        'status',
        'txn_id',
        'tx_ref',
    ];

    protected $hidden = ['created_at'];
}
