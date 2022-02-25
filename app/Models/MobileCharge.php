<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileCharge extends Model
{
    use HasFactory;

    // protected $attributes = [
    //     'user_id',
    //     'currency',
    //     'network',
    //     'amount',
    //     'email',
    //     'phone',
    //     'full_name',
    //     'status',
    //     'txn_id',
    //     'tx_ref',
    //     'redirect_url'
    // ];

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
        'tx_ref',
        'redirect_url'
    ];

    protected $hidden = ['created_at'];
}
